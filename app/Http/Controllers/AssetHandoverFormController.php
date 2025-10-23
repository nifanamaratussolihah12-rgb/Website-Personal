<?php

namespace App\Http\Controllers;

use App\Models\AssetHandoverForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AssetHandoverFormController extends Controller
{
    // Menampilkan daftar semua form serah terima asset (urut dari terbaru)
    public function index()
    {
        $handoverForms = AssetHandoverForm::latest()->get();
        return view('backend.v_assethandoverforms.index', compact('handoverForms'));
    }

    // Menampilkan halaman untuk membuat ajuan baru (form input)
    public function create()
    {
        // List pilihan tipe asset dan tipe serah terima untuk dropdown
        $assetTypes = ['PC / Laptop', 'Radio', 'Aksesoris Pendukung', 'Printer', 'UPS'];
        $handoverTypes = ['New Asset', 'Re-claimed Asset'];
        return view('backend.v_assethandoverforms.create', compact('assetTypes', 'handoverTypes'));
    }

    // Menyimpan data form serah terima baru ke database
    public function store(Request $request)
    {
        // Validasi semua input dari user
        $validated = $request->validate([
            //Bagian User
            'nama_user' => 'required|string',
            'nik_user' => 'required|string',
            'dept' => 'nullable|string',
            'section' => 'nullable|string',
            'tanggal' => 'required|date',
            //Bagian IT Staff
            'tipe_asset' => 'nullable|string',
            'handover_type' => 'nullable|string',
            'brand_asset' => 'nullable|string',
            'model_asset' => 'nullable|string',
            'asset_tag' => 'nullable|string',
            'asset_sn' => 'nullable|string',
            'ref_rl_acumatica' => 'nullable|string',
            'handover_by' => 'nullable|string',
            'handover_by_nik' => 'nullable|string',
            'handover_date' => 'nullable|date',
            'tanggal_dokumen' => 'nullable|date',
            'tanggal_expired' => 'nullable|date',

            // tambahan
            'status'  => 'nullable|in:pending approval,approval,done',
            'catatan' => 'nullable|string',

        ]);

        //dd($validated);
        //$namaAsset = $validated['brand_asset'] . ' ' . $validated['model_asset'];

        // Susun data yang akan disimpan ke database
        $data = [
            'nama_user' => $validated['nama_user'],
            'nik_user' => $validated['nik_user'],
            'dept' => $validated['dept'] ?? null,
            'section' => $validated['section'] ?? null,
            'tanggal' => $validated['tanggal'],

            'tipe_asset' => $validated['tipe_asset'],
            'handover_type' => $validated['handover_type'], // disimpan dengan nama field berbeda
            'brand_asset' => $validated['brand_asset'],
            'model_asset' => $validated['model_asset'],
            'nama_asset' => $validated['brand_asset'].' '.$validated['model_asset'], // digabungkan untuk jadi nama asset
            'asset_tag' => $validated['asset_tag'] ?? null,
            'asset_sn' => $validated['asset_sn'] ?? null,
            'ref_rl_acumatica' => $validated['ref_rl_acumatica'] ?? null,
            'handover_by' => $validated['handover_by'],
            'handover_by_nik' => $validated['handover_by_nik'] ?? null,
            'handover_date' => $validated['handover_date'],
            'tanggal_dokumen' => $validated['tanggal_dokumen'],
            'tanggal_expired' => $validated['tanggal_expired'],

            // tambahan
            'status'  => $validated['status'] ?? 'pending approval',
            'catatan' => $validated['catatan'] ?? null,

        ];

        //dd($validated);  

        try {
            // Simpan data ke tabel AssetHandoverForm
            $handoverForm = AssetHandoverForm::create($data);

            // Simpan ID form ke session (mungkin dipakai lagi nanti)
            session(['handover_id' => $handoverForm->id]);

            //Buat notifikasi untuk semua admin
            $admins = User::where('role', 0)->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'message' => Auth::user()->name . ' Mengajukan Form Serah Terima Asset IT',
                    'link' => route('backend.assethandoverforms.index'),
                    'created_at' => now(), // tanggal & jam
                ]);
            }

            // Buat notifikasi untuk user pengirim
            Notification::create([
                'user_id'   => Auth::id(),
                'message'   => 'Form Serah Terima Asset IT kamu berhasil dikirim',
                'link'      => route('backend.assethandoverforms.index'), // bisa diarahkan ke detail form juga
                'is_read'   => 0,
                'created_at'=> now(),
            ]);

            return redirect()
                ->back()
                ->with('success', 'Formulir berhasil diajukan!');
        } catch (\Exception $e) {
            // Jika gagal simpan → tampilkan error
            dd($e->getMessage());
            \Log::error("Gagal simpan form: ".$e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    // Menampilkan detail dari form tertentu
    public function show($id)
    {
        $handover = AssetHandoverForm::findOrFail($id);
        return view('backend.v_assethandoverforms.show', compact('handover'));
    }

    // Cetak form ke file PDF lalu tampilkan/stream ke browser
    public function cetakAssetHandover($id)
    {
        $form = AssetHandoverForm::findOrFail($id);

        $form->formatted_tanggal = Carbon::parse($form->tanggal)->translatedFormat('d F Y');
        $form->formatted_handover_date = $form->handover_date 
            ? Carbon::parse($form->handover_date)->translatedFormat('d F Y')
            : null;

        $data = [
            'judul' => 'Asset Handover Form',
            'form' => $form
        ];

        $pdf = Pdf::loadView('backend.v_assethandoverforms.cetak', $data)
                ->setPaper('a4', 'portrait');

        $folderPath = storage_path('app/public/pdf');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        $fileName = 'Asset Handover Form_' . $form->id . '.pdf';
        $pdf->save($folderPath . '/' . $fileName);

        return $pdf->stream($fileName);
    }

    // Export PDF dengan cara langsung generate dan stream
    public function exportPdf($id)
    {
        // Cari data form berdasarkan ID, kalau tidak ada error 404
        $form = AssetHandoverForm::findOrFail($id);

        // Generate PDF dari view 'cetak' dengan data form
        $pdf = Pdf::loadView('backend.v_assethandoverforms.cetak', compact('form'));

        // Tentukan nama file unik berdasarkan ID form
        $fileName = 'assethandover_' . $form->id . '.pdf';
        $filePath = storage_path('app/public/pdf/' . $fileName);

        // Simpan PDF ke storage/public/pdf
        $pdf->save($filePath);

        // Buat URL publik untuk PDF (bisa diakses lewat browser)
        $pdfUrl = asset('storage/pdf/' . $fileName);

        // Reload view PDF dengan tambahan variabel pdfUrl
        $pdf = Pdf::loadView('backend.v_assethandoverforms.cetak', [
            'form' => $form,
            'pdfUrl' => $pdfUrl,
        ]);

        // Stream (tampilkan langsung di browser, tidak otomatis download)
        return $pdf->stream($fileName, [
            'Attachment' => false // false = preview di browser
        ]);
    }

    // Versi lebih aman untuk cetak & simpan PDF
    public function cetakSafe($id)
    {
        $form = AssetHandoverForm::findOrFail($id);

        try {
            // Generate PDF dari view
            $pdf = Pdf::loadView('backend.v_assethandoverforms.cetak', compact('form'));

            // Pastikan folder tujuan ada (storage/app/public/pdf)
            $folderPath = storage_path('app/public/pdf');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            // Tentukan nama dan path file
            $fileName = 'assethandover_' . $form->id . '.pdf';
            $filePath = $folderPath . '/' . $fileName;

            // Simpan PDF ke storage
            $pdf->save($filePath);

            // URL publik untuk file PDF (opsional bisa dipakai di view)
            $pdfUrl = asset('storage/pdf/' . $fileName);

            // Tampilkan PDF langsung di browser
            return $pdf->stream($fileName);

        } catch (\Exception $e) {
            // Jika gagal, tulis log error
            \Log::error("Gagal cetak Asset Handover Form: " . $e->getMessage());

            // Redirect balik dengan warning
            return redirect()->route('backend.assethandoverforms.index')
                            ->with('warning', 'Form berhasil disimpan, tapi cetak gagal.');
        }
    }

    // Hapus data AssetHandoverForm
    public function destroy($id)
    {
        // Cari data berdasarkan ID
        $handover = AssetHandoverForm::findOrFail($id);

        // Hapus dari database
        $handover->delete();

        // Redirect balik dengan notifikasi sukses
        return redirect()
            ->route('backend.assethandoverforms.index')
            ->with('success', 'Formulir serah terima berhasil dihapus.');
    }

    public function edit($id)
    {
        $form = AssetHandoverForm::findOrFail($id);
        return view('backend.v_assethandoverforms.edit', compact('form'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_user' => 'required|string',
            'nik_user' => 'required|string',
            'dept' => 'nullable|string',
            'section' => 'nullable|string',
            'tanggal' => 'required|date',

            'tipe_asset' => 'required|string',
            'handover_type' => 'required|string',
            'brand_asset' => 'nullable|string',
            'model_asset' => 'nullable|string',
            'asset_tag' => 'nullable|string',
            'asset_sn' => 'nullable|string',
            'ref_rl_acumatica' => 'nullable|string',
            'handover_by' => 'required|string',
            'handover_by_nik' => 'nullable|string',
            'handover_date' => 'required|date',
            'tanggal_dokumen' => 'required|date',
            'tanggal_expired' => 'required|date',

            // tambahan
            'status'  => 'nullable|in:pending approval,approval,done',
            'catatan' => 'nullable|string',
        ]);

        $form = AssetHandoverForm::findOrFail($id);

        $data = [
            'nama_user' => $validated['nama_user'],
            'nik_user' => $validated['nik_user'],
            'dept' => $validated['dept'] ?? null,
            'section' => $validated['section'] ?? null,
            'tanggal' => $validated['tanggal'],

            'tipe_asset' => $validated['tipe_asset'],
            'handover_type' => $validated['handover_type'],
            'brand_asset' => $validated['brand_asset'],
            'model_asset' => $validated['model_asset'],
            'nama_asset' => $validated['brand_asset'].' '.$validated['model_asset'],
            'asset_tag' => $validated['asset_tag'] ?? null,
            'asset_sn' => $validated['asset_sn'] ?? null,
            'ref_rl_acumatica' => $validated['ref_rl_acumatica'] ?? null,
            'handover_by' => $validated['handover_by'],
            'handover_by_nik' => $validated['handover_by_nik'] ?? null,
            'handover_date' => $validated['handover_date'],
            'tanggal_dokumen' => $validated['tanggal_dokumen'],
            'tanggal_expired' => $validated['tanggal_expired'],

            // tambahan
            'status'  => $validated['status'] ?? $requestData->status,
            'catatan' => $validated['catatan'] ?? $requestData->catatan,
        ];

        $form->update($data);

        return redirect()->route('backend.assethandoverforms.index')
            ->with('success', 'Form berhasil diperbarui');
    }
}

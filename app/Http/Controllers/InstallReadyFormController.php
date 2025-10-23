<?php

namespace App\Http\Controllers;

use App\Models\InstallReadyForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class InstallReadyFormController extends Controller
{
    // Menampilkan daftar Install Ready Form
    public function index()
    {
        $forms = InstallReadyForm::latest()->get();
        return view('backend.v_installreadyform.index', compact('forms'));
    }

    // Menampilkan halaman buat Install Ready Form baru
    public function create()
    {
        return view('backend.v_installreadyform.create');
    }

    // Menyimpan data Install Ready Form
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'tim_pelaksana' => 'required|string|max:255',
            'catatan' => 'nullable|string|max:255',
            'manajemen' => 'nullable|array',
            'pasca' => 'nullable|array',
            'persiapan_awal' => 'nullable|array',
            'k3' => 'nullable|array',
            'aspek_teknis' => 'nullable|array',
            'tanggal_dokumen'  => 'nullable|date',
            'tanggal_expired'  => 'nullable|date',

            // tambahan
            'status'  => 'nullable|in:pending approval,approval,done',
            'note' => 'nullable|string',
        ]);

        $validated['tanggal'] = now()->format('Y-m-d');

        // Pastikan checkbox yang kosong menjadi array
        $validated['persiapan_awal'] = $request->persiapan_awal ?? [];
        $validated['k3'] = $request->k3 ?? [];
        $validated['aspek_teknis'] = $request->aspek_teknis ?? [];
        $validated['manajemen'] = $request->manajemen ?? [];
        $validated['pasca'] = $request->pasca ?? [];

        try {
            DB::beginTransaction();

            $form = InstallReadyForm::create($validated);

            DB::commit();

            session(['installreadyform_id' => $form->id]);

            //Buat notifikasi untuk semua admin
            $admins = User::where('role', 0)->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'message' => Auth::user()->name . ' Mengajukan Form Readiness/Kesiapan Instalasi',
                    'link' => route('backend.installreadyform.index'), // arahkan ke index installreadyform
                    'created_at' => now(), // tanggal & jam
                ]);
            }

            // Buat notifikasi untuk user pengirim
            Notification::create([
                'user_id'   => Auth::id(),
                'message'   => 'Form Readiness/Kesiapan Instalasi kamu berhasil dikirim',
                'link'      => route('backend.installreadyform.index'), // bisa diarahkan ke detail form juga
                'is_read'   => 0,
                'created_at'=> now(),
            ]);

            return redirect()->back()->with('success', 'Formulir readiness berhasil dibuat!');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd([
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    // Menampilkan detail Install Ready Form
    public function show($id)
    {
        $form = InstallReadyForm::findOrFail($id);
        return view('backend.v_installreadyform.show', compact('form'));
    }

    // Cetak / print Install Ready Form
    public function cetakInstallReady($id)
    {
        $form = InstallReadyForm::findOrFail($id);

        $data = [
            'judul' => 'Install Ready Form',
            'form' => $form
        ];

        $pdf = Pdf::loadView('backend.v_installreadyform.cetak', $data)
                  ->setPaper('a4', 'portrait');

        // Pastikan folder storage/pdf ada
        $folderPath = storage_path('app/public/pdf');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        // Nama file pakai format "Install Ready Form_ID.pdf"
        $fileName = 'Install Ready Form_' . $form->id . '.pdf';
        $pdf->save($folderPath . '/' . $fileName);

        // Stream ke browser
        return $pdf->stream($fileName);
    }

    public function exportPdf($id)
    {
        $form = InstallReadyForm::findOrFail($id);

        $pdf = Pdf::loadView('backend.v_installreadyform.cetak', compact('form'));

        // Tentukan nama file unik
        $fileName = 'install_ready_form_' . $form->id . '.pdf';
        $filePath = storage_path('app/public/pdf/' . $fileName);

        // Simpan ke storage/public/pdf
        $pdf->save($filePath);

        // URL publik ke PDF
        $pdfUrl = asset('storage/pdf/' . $fileName);

        // Kirim variabel ke view (misal untuk link sumber)
        $pdf = Pdf::loadView('backend.v_installreadyform.cetak', [
            'form' => $form,
            'pdfUrl' => $pdfUrl,
        ]);

        return $pdf->stream($fileName, [
            'Attachment' => false
        ]);
    }

    public function cetakSafe($id)
    {
        $form = InstallReadyForm::findOrFail($id);

        try {
            $pdf = Pdf::loadView('backend.v_installreadyform.cetak', compact('form'));

            // pastikan folder ada
            $folderPath = storage_path('app/public/pdf');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            $fileName = 'install_ready_form_' . $form->id . '.pdf';
            $filePath = $folderPath . '/' . $fileName;

            // simpan PDF ke storage
            $pdf->save($filePath);

            // URL publik
            $pdfUrl = asset('storage/pdf/' . $fileName);

            // Bisa juga kirim URL ke view kalau mau ditampilkan linknya
            return $pdf->stream($fileName);

        } catch (\Exception $e) {
            Log::error("Gagal cetak Install Ready Form: " . $e->getMessage());
            return redirect()->route('backend.installreadyform.index')
                            ->with('warning', 'Form berhasil disimpan, tapi cetak gagal.');
        }
    }

    // Hapus data Install Ready Form
    public function destroy($id)
    {
        $form = InstallReadyForm::findOrFail($id);
        $form->delete();

        return redirect()
            ->route('backend.installreadyform.index')
            ->with('success', 'Formulir readiness berhasil dihapus.');
    }

    // Menampilkan halaman edit Install Ready Form
    public function edit($id)
    {
        $form = InstallReadyForm::findOrFail($id);
        return view('backend.v_installreadyform.edit', compact('form'));
    }

    // Update data Install Ready Form
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'project' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'tim_pelaksana' => 'required|string|max:255',
            'catatan' => 'nullable|string|max:255',
            'manajemen' => 'nullable|array',
            'pasca' => 'nullable|array',
            'persiapan_awal' => 'nullable|array',
            'k3' => 'nullable|array',
            'aspek_teknis' => 'nullable|array',
            'tanggal_dokumen'  => 'nullable|date',
            'tanggal_expired'  => 'nullable|date',

            // tambahan
            'status'  => 'nullable|in:pending approval,approval,done',
            'note' => 'nullable|string',
        ]);

        // Pastikan checkbox tetap array meskipun kosong
        $validated['persiapan_awal'] = $request->persiapan_awal ?? [];
        $validated['k3'] = $request->k3 ?? [];
        $validated['aspek_teknis'] = $request->aspek_teknis ?? [];
        $validated['manajemen'] = $request->manajemen ?? [];
        $validated['pasca'] = $request->pasca ?? [];

        try {
            DB::beginTransaction();

            $form = InstallReadyForm::findOrFail($id);
            $form->update($validated);

            DB::commit();

            return redirect()
                ->route('backend.installreadyform.show', $form->id)
                ->with('success', 'Formulir readiness berhasil diperbarui!');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd([
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

}

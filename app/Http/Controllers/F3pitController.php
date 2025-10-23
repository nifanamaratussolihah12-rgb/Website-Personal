<?php

namespace App\Http\Controllers;

use App\Models\F3pit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class F3pitController extends Controller
{
    // Menampilkan daftar F3PIT
    public function index()
    {
        $forms = F3pit::latest()->get();
        return view('backend.v_f3pit.index', compact('forms'));
    }

    // Menampilkan halaman buat F3PIT baru
    public function create()
    {
        return view('backend.v_f3pit.create');
    }

    // Simpan data F3PIT
    public function store(Request $request)
    {
        $validated = $request->validate([
            'departement' => 'nullable|string|max:255',
            'pic' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'kode_inventaris' => 'nullable|string|max:255',
            'tahun_perolehan' => 'nullable|date',
            'jenis_inventaris' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:500',
            'tipe' => 'nullable|string|max:500',
            'sn' => 'nullable|string|max:255',
            'tanggal_dokumen'  => 'nullable|date',
            'tanggal_expired'  => 'nullable|date',

            'sejarah_tanggal' => 'nullable|date',
            'sejarah_keterangan' => 'nullable|string',

            'deskripsi_permasalahan' => 'nullable|string',

            'penyebab_kerusakan' => 'nullable|array',
            'langkah_dilakukan' => 'nullable|array',

            'kondisi_fisik' => 'nullable|string',
            'prioritas_pengerjaan' => 'nullable|in:normal,urgent,top_urgent',

            'pemohon' => 'nullable|string|max:255',
            'dep_head' => 'nullable|string|max:255',
            'kelengkapan_dokumen' => 'nullable|boolean',
            'lampiran_formulir' => 'nullable|boolean',

            'diterima_oleh' => 'nullable|string|max:255',
            'tanggal' => 'nullable|date',
            'garansi_sebelumnya' => 'nullable|date',

            'pemeriksaan_teknis_oleh' => 'nullable|string|max:255',
            'diputuskan_internal_it' => 'nullable|array',
            'diputuskan_vendor' => 'nullable|array',

            'hasil_diperiksa_oleh' => 'nullable|string|max:255',
            'hasil_diperiksa_tgl' => 'nullable|date',
            'sn_sesuai' => 'nullable|boolean',
            'bukti_penggantian' => 'nullable|boolean',

            // tambahan
            'status'  => 'nullable|in:pending approval,approval,done',
            'catatan' => 'nullable|string',
        ]);

        $validated['langkah_dilakukan'] = $request->input('langkah_dilakukan') ?? [];

        $penyebab = $request->penyebab_kerusakan ?? [];

        // 1️⃣ Jika user isi notes “Lainnya”, set checkbox lainnya = "Lainnya"
        if (!empty($penyebab['lainnya_notes'])) {
            foreach ($penyebab as $key => $value) {
                if ($key !== 'lainnya_notes') {
                    $penyebab[$key] = Str::limit($value, 500); // Maksimal 500 karakter
                }
            }
        }

        // 2️⃣ Hapus checkbox "lainnya_checkbox" karena tidak perlu disimpan
        unset($penyebab['lainnya_checkbox']);

        $validated['penyebab_kerusakan'] = $penyebab;

        try {
            DB::beginTransaction();

            $form = F3pit::create($validated);

            DB::commit();

            session(['f3pit_id' => $form->id]);

            //Buat notifikasi untuk semua admin
            $admins = User::where('role', 0)->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'message' => Auth::user()->name . ' Mengajukan Form F3PIT',
                    'link' => route('backend.f3pit.index'),
                    'created_at' => now(), // tanggal & jam
                ]);
            }

            // Buat notifikasi untuk user pengirim
            Notification::create([
                'user_id'   => Auth::id(),
                'message'   => 'Form F3PIT kamu berhasil dikirim',
                'link'      => route('backend.f3pit.index'), // bisa diarahkan ke detail form juga
                'is_read'   => 0,
                'created_at'=> now(),
            ]);

            return redirect()->back()->with('success', 'Formulir F3PIT berhasil dibuat!');
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

    // Detail F3PIT
    public function show($id)
    {
        $form = F3pit::findOrFail($id);
        return view('backend.v_f3pit.show', compact('form'));
    }

    // Cetak / print F3PIT
    public function cetakF3pit($id)
    {
        $form = F3pit::findOrFail($id);

        //dd($form->penyebab_kerusakan);

        $data = [
            'judul' => 'Formulir Permintaan Perbaikan Perangkat IT (F3PIT)',
            'form' => $form
        ];

        $pdf = Pdf::loadView('backend.v_f3pit.cetak', $data)
                  ->setPaper('a4', 'portrait');

        $folderPath = storage_path('app/public/pdf');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        $fileName = 'F3PIT_' . $form->id . '.pdf';
        $pdf->save($folderPath . '/' . $fileName);

        return $pdf->stream($fileName);
    }

    public function exportPdf($id)
    {
        $form = F3pit::findOrFail($id);

        $pdf = Pdf::loadView('pdf.f3pit', compact('form'));
        $fileName = 'f3pit_' . $form->id . '.pdf';
        $filePath = storage_path('app/public/pdf/' . $fileName);

        $pdf->save($filePath);

        $pdfUrl = asset('storage/pdf/' . $fileName);

        $pdf = Pdf::loadView('pdf.f3pit', [
            'form' => $form,
            'pdfUrl' => $pdfUrl,
        ]);

        return $pdf->stream($fileName, [
            'Attachment' => false
        ]);
    }

    public function cetakSafe($id)
    {
        $form = F3pit::findOrFail($id);

        try {
            $pdf = Pdf::loadView('pdf.f3pit', compact('form'));

            $folderPath = storage_path('app/public/pdf');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            $fileName = 'f3pit_' . $form->id . '.pdf';
            $filePath = $folderPath . '/' . $fileName;

            $pdf->save($filePath);

            $pdfUrl = asset('storage/pdf/' . $fileName);

            return $pdf->stream($fileName);
        } catch (\Exception $e) {
            Log::error("Gagal cetak F3PIT: " . $e->getMessage());
            return redirect()->route('f3pit.index')
                            ->with('warning', 'Form berhasil disimpan, tapi cetak gagal.');
        }
    }

    // Hapus data
    public function destroy($id)
    {
        $form = F3pit::findOrFail($id);
        $form->delete();

        return redirect()
            ->route('backend.f3pit.index')
            ->with('success', 'Formulir F3PIT berhasil dihapus.');
    }

    // 📝 Halaman edit
    public function edit($id)
    {
        $form = F3pit::findOrFail($id);
        return view('backend.v_f3pit.edit', compact('form'));
    }

    // 🔄 Update data
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'departement' => 'nullable|string|max:255',
            'pic' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'kode_inventaris' => 'nullable|string|max:255',
            'tahun_perolehan' => 'nullable|date',
            'jenis_inventaris' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:500',
            'tipe' => 'nullable|string|max:500',
            'sn' => 'nullable|string|max:255',
            'tanggal_dokumen'  => 'nullable|date',
            'tanggal_expired'  => 'nullable|date',

            'sejarah_tanggal' => 'nullable|date',
            'sejarah_keterangan' => 'nullable|string',

            'deskripsi_permasalahan' => 'nullable|string',

            'penyebab_kerusakan' => 'nullable|array',
            'langkah_dilakukan' => 'nullable|array',

            'kondisi_fisik' => 'nullable|string',
            'prioritas_pengerjaan' => 'nullable|in:normal,urgent,top_urgent',

            'pemohon' => 'nullable|string|max:255',
            'dep_head' => 'nullable|string|max:255',
            'kelengkapan_dokumen' => 'nullable|boolean',
            'lampiran_formulir' => 'nullable|boolean',

            'diterima_oleh' => 'nullable|string|max:255',
            'tanggal' => 'nullable|date',
            'garansi_sebelumnya' => 'nullable|date',

            'pemeriksaan_teknis_oleh' => 'nullable|string|max:255',
            'diputuskan_internal_it' => 'nullable|array',
            'diputuskan_vendor' => 'nullable|array',

            'hasil_diperiksa_oleh' => 'nullable|string|max:255',
            'hasil_diperiksa_tgl' => 'nullable|date',
            'sn_sesuai' => 'nullable|boolean',
            'bukti_penggantian' => 'nullable|boolean',

            // tambahan
            'status'  => 'nullable|in:pending approval,approval,done',
            'catatan' => 'nullable|string',
        ]);

        $validated['langkah_dilakukan'] = $request->input('langkah_dilakukan') ?? [];

        $penyebab = $request->penyebab_kerusakan ?? [];

        // Kalau ada catatan lain, simpan notes-nya
        if (!empty($penyebab['lainnya_notes'])) {
            foreach ($penyebab as $key => $value) {
                if ($key !== 'lainnya_notes') {
                    $penyebab[$key] = Str::limit($value, 500);
                }
            }
        }

        unset($penyebab['lainnya_checkbox']);
        $validated['penyebab_kerusakan'] = $penyebab;

        try {
            DB::beginTransaction();

            $form = F3pit::findOrFail($id);
            $form->update($validated);

            DB::commit();

            return redirect()
                ->route('backend.f3pit.index')
                ->with('success', 'Formulir F3PIT berhasil diperbarui!');
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

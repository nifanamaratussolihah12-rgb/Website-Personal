<?php

namespace App\Http\Controllers;

use App\Models\Finding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class FindingController extends Controller
{
    // Menampilkan daftar Finding
    public function index()
    {
        $findings = Finding::latest()->get();
        return view('backend.v_finding.index', compact('findings'));
    }

    // Menampilkan halaman buat Finding baru
    public function create()
    {
        return view('backend.v_finding.create');
    }

    // Menyimpan data Finding
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_departemen' => 'nullable|string|max:255',
            'lokasi_temuan' => 'nullable|string|max:255',
            'tanggal_penemuan' => 'nullable|date',
            'judul_temuan' => 'nullable|string|max:255',
            'deskripsi_temuan' => 'nullable|string',
            'form_readiness_terkait' => 'nullable|string|max:255',
            'tanggal_form_readiness' => 'nullable|date',
            'bukti_temuan_foto' => 'nullable|file|image|max:5120', // max 5MB
            'bukti_temuan_text' => 'nullable|string|max:255',
            'analisis_penyebab' => 'nullable|string',
            'analisis_dampak' => 'nullable|string',
            'tindakan_sementara' => 'nullable|string',
            'tindakan_perbaikan' => 'nullable|string',
            'penanggung_jawab_tindakan' => 'nullable|string|max:255',
            'target_waktu_penyelesaian' => 'nullable|date',
            'status_follow_up' => 'nullable|in:PJO,MANAJEMEN,DIREKSI',
            'tanggal_verifikasi' => 'nullable|date',
            'hasil_verifikasi' => 'nullable|string',
            'tanggal_dokumen'  => 'nullable|date',
            'tanggal_expired'  => 'nullable|date',

            // tambahan
            'status'  => 'nullable|in:pending approval,approval,done',
            'catatan' => 'nullable|string',
        ]);

        //dd($validated);

        try {
            if ($request->hasFile('bukti_temuan_foto')) {
                $file = $request->file('bukti_temuan_foto');
                $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('bukti-temuan', $filename, 'public');
                $validated['bukti_temuan_foto'] = $path;
            }

            $finding = Finding::create($validated);

            // simpan id ke session kalau perlu
            session(['finding_id' => $finding->id]);

            //Buat notifikasi untuk semua admin
            $admins = User::where('role', 0)->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'message' => Auth::user()->name . ' Mengajukan Form Finding',
                    'link' => route('backend.finding.index'), // arahkan ke index Finding
                    'created_at' => now(), // tanggal & jam
                ]);
            }

            // Buat notifikasi untuk user pengirim
            Notification::create([
                'user_id'   => Auth::id(),
                'message'   => 'Form Finding kamu berhasil dikirim',
                'link'      => route('backend.finding.index'), // bisa diarahkan ke detail form juga
                'is_read'   => 0,
                'created_at'=> now(),
            ]);

            return redirect()
                ->back()
                ->with('success', 'Data Finding berhasil disimpan!');
        } catch (\Exception $e) {
            dd($e->getMessage()); // biar langsung ketahuan error-nya
            \Log::error("Gagal simpan finding: " . $e->getMessage());

            return redirect()
                ->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }

    }

    // Menampilkan detail Finding
    public function show($id)
    {
        $finding = Finding::findOrFail($id);
        return view('backend.v_finding.show', compact('finding'));
    }

    // Cetak / print Finding
    public function cetakFinding($id)
    {
        $finding = Finding::findOrFail($id);

        $data = [
            'judul' => 'Finding Form',
            'finding' => $finding
        ];

        $pdf = Pdf::loadView('backend.v_finding.cetak', $data)
                ->setPaper('a4', 'portrait');

        // Pastikan folder ada
        $folderPath = storage_path('app/public/pdf');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        // Nama file pakai format "Finding Form_ID.pdf"
        $fileName = 'Finding Form_' . $finding->id . '.pdf'; // tambahin spasi & format
        $pdf->save($folderPath . '/' . $fileName);

        // Stream ke browser
        return $pdf->stream($fileName);
    }

    public function exportPdf($id)
    {
        $finding = Finding::findOrFail($id);

        $pdf = \PDF::loadView('pdf.finding', compact('finding'));

        // Tentukan nama file unik
        $fileName = 'finding_' . $finding->id . '.pdf';
        $filePath = storage_path('app/public/pdf/' . $fileName);

        // Simpan ke storage/public/pdf
        $pdf->save($filePath);

        // URL publik ke PDF
        $pdfUrl = asset('storage/pdf/' . $fileName);

        // Kirim variabel ke view
        $pdf = \PDF::loadView('pdf.finding', [
            'finding' => $finding,
            'pdfUrl' => $pdfUrl,
        ]);

        return $pdf->stream($fileName, [
            'Attachment' => false
        ]);
    }

    public function cetakSafe($id)
    {
        $finding = Finding::findOrFail($id);

        try {
            $pdf = Pdf::loadView('pdf.finding', compact('finding'));

            // pastikan folder ada
            $folderPath = storage_path('app/public/pdf');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            $fileName = 'finding_' . $finding->id . '.pdf';
            $filePath = $folderPath . '/' . $fileName;

            // simpan PDF ke storage
            $pdf->save($filePath);

            // URL publik
            $pdfUrl = asset('storage/pdf/' . $fileName);

            // bisa juga kirim URL ke view kalau mau ditampilkan linknya
            return $pdf->stream($fileName);

        } catch (\Exception $e) {
            Log::error("Gagal cetak Finding: " . $e->getMessage());
            return redirect()->route('finding.index')
                            ->with('warning', 'Data berhasil disimpan, tapi cetak gagal.');
        }
    }

    // Hapus data Finding
    public function destroy($id)
    {
        $finding = Finding::findOrFail($id);
        $finding->delete();

        return redirect()
            ->route('backend.finding.index')
            ->with('success', 'Finding berhasil dihapus.');
    }

    // Menampilkan form edit Finding
    public function edit($id)
    {
        $finding = Finding::findOrFail($id);
        return view('backend.v_finding.edit', compact('finding'));
    }

    // Update data Finding
    public function update(Request $request, $id)
    {
        $finding = Finding::findOrFail($id);

        $validated = $request->validate([
            'nama_departemen' => 'nullable|string|max:255',
            'lokasi_temuan' => 'nullable|string|max:255',
            'tanggal_penemuan' => 'nullable|date',
            'judul_temuan' => 'nullable|string|max:255',
            'deskripsi_temuan' => 'nullable|string',
            'form_readiness_terkait' => 'nullable|string|max:255',
            'tanggal_form_readiness' => 'nullable|date',
            'bukti_temuan_foto' => 'nullable|file|image|max:5120', // max 5MB
            'bukti_temuan_text' => 'nullable|string|max:255',
            'analisis_penyebab' => 'nullable|string',
            'analisis_dampak' => 'nullable|string',
            'tindakan_sementara' => 'nullable|string',
            'tindakan_perbaikan' => 'nullable|string',
            'penanggung_jawab_tindakan' => 'nullable|string|max:255',
            'target_waktu_penyelesaian' => 'nullable|date',
            'status_follow_up' => 'nullable|in:PJO,MANAJEMEN,DIREKSI',
            'tanggal_verifikasi' => 'nullable|date',
            'hasil_verifikasi' => 'nullable|string',
            'tanggal_dokumen'  => 'nullable|date',
            'tanggal_expired'  => 'nullable|date',

            // tambahan
            'status'  => 'nullable|in:pending approval,approval,done',
            'catatan' => 'nullable|string',
        ]);

        try {
            // Handle upload foto baru
            if ($request->hasFile('bukti_temuan_foto')) {
                // Hapus file lama jika ada
                if ($finding->bukti_temuan_foto && \Storage::disk('public')->exists($finding->bukti_temuan_foto)) {
                    \Storage::disk('public')->delete($finding->bukti_temuan_foto);
                }

                $file = $request->file('bukti_temuan_foto');
                $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('bukti-temuan', $filename, 'public');
                $validated['bukti_temuan_foto'] = $path;
            }

            $finding->update($validated);

            return redirect()
                ->route('backend.finding.index')
                ->with('success', 'Data Finding berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error("Gagal update finding: " . $e->getMessage());
            return redirect()
                ->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }
}

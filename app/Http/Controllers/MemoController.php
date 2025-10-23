<?php

namespace App\Http\Controllers;

use App\Models\Memo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class MemoController extends Controller
{
    // Menampilkan daftar Memo
    public function index()
    {
        $memos = Memo::latest()->get();
        return view('backend.v_memo.index', compact('memos'));
    }

    // Menampilkan form buat Memo baru
    public function create()
    {
        return view('backend.v_memo.create');
    }

    // Simpan Memo baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Disposisi
            'tgl_no_surat'       => 'nullable|string|max:255',
            'perihal'            => 'nullable|array',
            'lampiran'           => 'nullable|string|max:255',
            'dari_disposisi'     => 'nullable|string|max:255',
            'disposisi'          => 'nullable|array',
            'tanggal_disposisi'  => 'nullable|date',

            // Memo 
            'tanggal_memo'       => 'nullable|date',
            'lokasi_memo'        => 'nullable|string|max:255',
            'nomor'              => 'nullable|string|max:255',
            'kepada'             => 'nullable|string|max:255',
            'dari_memo'          => 'nullable|string|max:255',
            'perihal_memo'       => 'nullable|string|max:255',
            'isi'                => 'nullable|string',

            // TTD
            'ttd_disusun_nama'      => 'nullable|string|max:255',
            'ttd_disusun_jabatan'   => 'nullable|string|max:255',
            'ttd_diperiksa_nama'    => 'nullable|string|max:255',
            'ttd_diperiksa_jabatan' => 'nullable|string|max:255',
            'ttd_disetujui_nama'    => 'nullable|string|max:255',
            'ttd_disetujui_jabatan' => 'nullable|string|max:255',

            // tambahan
            'status'  => 'nullable|in:pending approval,approval,done',
            'catatan' => 'nullable|string',
        ]);

        //dd($request->all());

        try {
            //perihal
            if ($request->has('perihal')) {
                $validated['perihal'] = json_encode($request->input('perihal'));
            }
            
            //disposisi
            $disposisi_atas_rows = [];
            $atas = $request->input('disposisi_atas', []);
            if (!empty($atas['tujuan'])) {
                $count = count($atas['tujuan']);
                for ($i = 0; $i < $count; $i++) {
                    $disposisi_atas_rows[] = [
                        'tujuan' => $atas['tujuan'][$i] ?? '',
                        'status' => $atas['status'][$i] ?? '',
                        'keterangan' => $atas['keterangan'][$i] ?? '',
                    ];
                }
            }
            $disposisi['atas'] = $disposisi_atas_rows;

            // Lakukan hal sama untuk disposisi_bawah
            $disposisi_bawah_rows = [];
            $bawah = $request->input('disposisi_bawah', []);
            if (!empty($bawah['tujuan'])) {
                $count = count($bawah['tujuan']);
                for ($i = 0; $i < $count; $i++) {
                    $disposisi_bawah_rows[] = [
                        'tujuan' => $bawah['tujuan'][$i] ?? '',
                        'status' => $bawah['status'][$i] ?? '',
                        'keterangan' => $bawah['keterangan'][$i] ?? '',
                    ];
                }
            }
            $disposisi['bawah'] = $disposisi_bawah_rows;

            $validated['disposisi'] = json_encode($disposisi);

            $memo = Memo::create($validated);

            // simpan id ke session kalau perlu
            session(['memo_id' => $memo->id]);

            // Buat notifikasi untuk semua admin
            $admins = User::where('role', 0)->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id'   => $admin->id,
                    'message'   => Auth::user()->name . ' Membuat Memo baru',
                    'link'      => route('backend.memo.index'),
                    'created_at'=> now(),
                ]);
            }

            // Buat notifikasi untuk user pengirim
            Notification::create([
                'user_id'   => Auth::id(),
                'message'   => 'Memo kamu berhasil dibuat',
                'link'      => route('backend.memo.index'),
                'is_read'   => 0,
                'created_at'=> now(),
            ]);

            return redirect()
                ->back()
                ->with('success', 'Data Memo berhasil disimpan!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error("Gagal simpan memo: " . $e->getMessage());

            return redirect()
                ->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    // Detail Memo
    public function show($id)
    {
        $memo = Memo::findOrFail($id);
        return view('backend.v_memo.show', compact('memo'));
    }

    // Cetak Memo (Disposisi + Memo = 2 halaman PDF)
    public function cetakMemo($id)
    {
        $memo = Memo::findOrFail($id);

        $data = [
            'judul' => 'Memo Form',
            'memo'  => $memo
        ];

        $pdf = Pdf::loadView('backend.v_memo.cetak', $data)
                ->setPaper('a4', 'portrait');

        $folderPath = storage_path('app/public/pdf');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        $fileName = 'Memo Form_' . $memo->id . '.pdf';
        $pdf->save($folderPath . '/' . $fileName);

        return $pdf->stream($fileName);
    }

    // Export PDF versi lain (opsional)
    public function exportPdf($id)
    {
        $memo = Memo::findOrFail($id);

        $pdf = Pdf::loadView('pdf.memo', compact('memo'));
        $fileName = 'memo_' . $memo->id . '.pdf';
        $filePath = storage_path('app/public/pdf/' . $fileName);
        $pdf->save($filePath);

        $pdfUrl = asset('storage/pdf/' . $fileName);

        $pdf = Pdf::loadView('pdf.memo', [
            'memo' => $memo,
            'pdfUrl' => $pdfUrl,
        ]);

        return $pdf->stream($fileName, ['Attachment' => false]);
    }

    // Cetak aman (pakai try-catch)
    public function cetakSafe($id)
    {
        $memo = Memo::findOrFail($id);

        try {
            $pdf = Pdf::loadView('pdf.memo', compact('memo'));

            $folderPath = storage_path('app/public/pdf');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            $fileName = 'memo_' . $memo->id . '.pdf';
            $filePath = $folderPath . '/' . $fileName;

            $pdf->save($filePath);

            return $pdf->stream($fileName);
        } catch (\Exception $e) {
            Log::error("Gagal cetak Memo: " . $e->getMessage());
            return redirect()->route('backend.memo.index')
                            ->with('warning', 'Data berhasil disimpan, tapi cetak gagal.');
        }
    }

    // Hapus Memo
    public function destroy($id)
    {
        $memo = Memo::findOrFail($id);
        $memo->delete();

        return redirect()
            ->route('backend.memo.index')
            ->with('success', 'Memo berhasil dihapus.');
    }

    // Form edit Memo
    public function edit($id)
    {
        $memo = Memo::findOrFail($id);

        // decode JSON jadi array
        $memo->disposisi = is_array($memo->disposisi)
            ? $memo->disposisi
            : json_decode($memo->disposisi, true);

        return view('backend.v_memo.edit', compact('memo'));
    }

    // Update Memo
    public function update(Request $request, $id)
    {
        $memo = Memo::findOrFail($id);

        $validated = $request->validate([
            'tgl_no_surat'       => 'nullable|string|max:255',
            'perihal'            => 'nullable|array',
            'lampiran'           => 'nullable|string|max:255',
            'dari_disposisi'     => 'nullable|string|max:255',
            'disposisi'          => 'nullable|array',
            'tanggal_disposisi'  => 'nullable|date',

            'tanggal_memo'       => 'nullable|date',
            'lokasi_memo'        => 'nullable|string|max:255',
            'nomor'              => 'nullable|string|max:255',
            'kepada'             => 'nullable|string|max:255',
            'dari_memo'          => 'nullable|string|max:255',
            'perihal_memo'       => 'nullable|string|max:255',
            'isi'                => 'nullable|string',

            // tambahan
            'status'  => 'nullable|in:pending approval,approval,done',
            'catatan' => 'nullable|string',

            // TTD
            'ttd_disusun_nama'      => 'nullable|string|max:255',
            'ttd_disusun_jabatan'   => 'nullable|string|max:255',
            'ttd_diperiksa_nama'    => 'nullable|string|max:255',
            'ttd_diperiksa_jabatan' => 'nullable|string|max:255',
            'ttd_disetujui_nama'    => 'nullable|string|max:255',
            'ttd_disetujui_jabatan' => 'nullable|string|max:255',
        ]);
        //dd($memo->disposisi);

        try {
            //perihal
            if ($request->has('perihal')) {
                $validated['perihal'] = json_encode($request->input('perihal'));
            }
            
            //disposisi
            $disposisi_atas_rows = [];
            $atas = $request->input('disposisi_atas', []);
            if (!empty($atas['tujuan'])) {
                $count = count($atas['tujuan']);
                for ($i = 0; $i < $count; $i++) {
                    $disposisi_atas_rows[] = [
                        'tujuan' => $atas['tujuan'][$i] ?? '',
                        'status' => $atas['status'][$i] ?? '',
                        'keterangan' => $atas['keterangan'][$i] ?? '',
                    ];
                }
            }
            $disposisi['atas'] = $disposisi_atas_rows;

            // Lakukan hal sama untuk disposisi_bawah
            $disposisi_bawah_rows = [];
            $bawah = $request->input('disposisi_bawah', []);
            if (!empty($bawah['tujuan'])) {
                $count = count($bawah['tujuan']);
                for ($i = 0; $i < $count; $i++) {
                    $disposisi_bawah_rows[] = [
                        'tujuan' => $bawah['tujuan'][$i] ?? '',
                        'status' => $bawah['status'][$i] ?? '',
                        'keterangan' => $bawah['keterangan'][$i] ?? '',
                    ];
                }
            }
            $disposisi['bawah'] = $disposisi_bawah_rows;

            $validated['disposisi'] = json_encode($disposisi);

            $memo->update($validated);

            return redirect()
                ->route('backend.memo.index')
                ->with('success', 'Data Memo berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error("Gagal update memo: " . $e->getMessage());
            return redirect()
                ->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }
}

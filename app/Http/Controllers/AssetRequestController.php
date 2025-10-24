<?php

namespace App\Http\Controllers;

use App\Models\AssetRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\AssetNumberSequence; 
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class AssetRequestController extends Controller
{
    // Menampilkan daftar permintaan asset
    public function index()
    {
        $requests = AssetRequest::latest()->get();
        return view('backend.v_assetrequest.index', compact('requests'));
    }

    // Menampilkan halaman buat permintaan baru
    public function create()
    {
        $asset = \App\Models\Asset::where('qty', '>', 0)
                    ->orderBy('item_name') // urut A-Z
                    ->get();

        return view('backend.v_assetrequest.create', compact('asset'));
    }

    // Simpan data permintaan asset
    public function store(Request $request)
    {
        //dd($request->details);

        $validated = $request->validate([
            'request_type' => 'required|string|max:255',
            'request_type_extra'  => 'nullable|string|max:255',
            'request_ref_num' => 'nullable|string|max:255',
            'tipe_penyerahan' => 'required|string',
            'nik' => 'required|string|max:255',
            'dept' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'asset_type' => 'required|string|max:255',
            'details' => 'required|array',
            'details.*.brand' => 'required|string|max:255',
            'details.*.model' => 'required|string|max:255',
            'details.*.qty' => 'required|integer|min:1',
            'details.*.user_pic' => 'required|string|max:255',
            'tanggal_dokumen' => 'nullable|date',
            'tanggal_expired' => 'nullable|date',

            // tambahan
            'status'  => 'nullable|in:pending approval,approval,done',
            'catatan' => 'nullable|string',

        ]);

        $data = [
            'request_type'    => $validated['request_type'],
            'request_type_extra'  => $validated['request_type_extra'] ?? null,
            'request_ref_num' => $validated['request_ref_num'] ?? null,
            'tipe_penyerahan' => $validated['tipe_penyerahan'],
            'nik'             => $validated['nik'],
            'dept'            => $validated['dept'],
            'section'         => $validated['section'],
            'asset_type'      => $validated['asset_type'],
            'details'         => $validated['details'],
            'tanggal_dokumen'  => $validated['tanggal_dokumen'],
            'tanggal_expired'  => $validated['tanggal_expired'],

            // tambahan
            'status'  => $validated['status'] ?? 'pending approval',
            'catatan' => $validated['catatan'] ?? null,

        ];

        // Cek apakah request ini New Asset
        if ($validated['tipe_penyerahan'] == 'New Asset') {
            $dept = $validated['dept'] ?: null;
            $section = $validated['section'] ?: null;
            $ym = date('Ym');

            // Ambil atau buat sequence
            $sequence = AssetNumberSequence::firstOrCreate(
                [
                    'dept' => $dept,
                    'section' => $section,
                    'year_month' => $ym
                ],
                ['last_number' => 0]
            );

            // Increment last_number
            $sequence->increment('last_number');

            // Generate kode unik
            $parts = [];
            if ($dept) $parts[] = $dept;
            if ($section) $parts[] = $section;
            $parts[] = 'NA';
            $parts[] = $ym;
            $parts[] = str_pad($sequence->last_number, 3, '0', STR_PAD_LEFT);

            $newAssetNumber = implode('-', $parts);

            // Simpan ke data
            $data['new_asset_number'] = $newAssetNumber;
        }

        // Filter detail: hanya simpan yang punya asset_id
        $filteredDetails = collect($request->details)
            ->filter(fn($d) => !empty($d['asset_id']))
            ->values()
            ->toArray();

        try {
            // Simpan data request
            $requestData = AssetRequest::create($data);

            // **Tambahkan disini**: kurangi qty asset dan simpan pivot
            foreach($filteredDetails as $detail){
                $asset = \App\Models\Asset::find($detail['asset_id']);
                if($asset->qty >= $detail['qty']){
                    $asset->qty -= $detail['qty'];
                    $asset->save();

                    // Simpan di pivot asset_request_items
                    $requestData->items()->create([
                        'asset_id' => $asset->id,
                        'qty' => $detail['qty']
                    ]);
                } else {
                    throw new \Exception("Stok asset '{$asset->item_name}' tidak cukup");
                }
            }

            session(['asset_request_id' => $requestData->id]);

            // Buat notifikasi untuk admin
            $admins = User::where('role', 0)->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'message' => Auth::user()->name . ' Mengajukan Form Permintaan Asset IT',
                    'link' => route('backend.assetrequest.index'),
                    'created_at' => now(),
                ]);
            }

            // Buat notifikasi untuk user
            Notification::create([
                'user_id'   => Auth::id(),
                'message'   => 'Form Permintaan Asset IT kamu berhasil dikirim',
                'link'      => route('backend.assetrequest.index'),
                'is_read'   => 0,
                'created_at'=> now(),
            ]);

            return redirect()
                ->back()
                ->with('success', 'Formulir permintaan asset berhasil diajukan!');

            // } catch (\Exception $e) {
            //     dd($e->getMessage(), $e->getTraceAsString());
            //     \Log::error("Gagal simpan form permintaan: " . $e->getMessage());
            //     return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
            // }
        } catch (\Exception $e) {
            \Log::error("Gagal simpan form permintaan: " . $e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    // Menampilkan detail permintaan asset
    public function show($id)
    {
        $requestData = AssetRequest::findOrFail($id);
        return view('backend.v_assetrequest.show', compact('requestData'));
    }

    // Cetak / print permintaan asset
    public function cetakAssetRequest($id)
    {
        $requestData = AssetRequest::findOrFail($id);

        $data = [
            'judul' => 'Asset Request Form',
            'requestData' => $requestData
        ];

        $pdf = Pdf::loadView('backend.v_assetrequest.cetak', $data)
                  ->setPaper('a4', 'portrait');

        // Pastikan folder storage/pdf ada
        $folderPath = storage_path('app/public/pdf');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        $fileName = 'Asset Request_' . $requestData->id . '.pdf';
        $pdf->save($folderPath . '/' . $fileName);

        return $pdf->stream($fileName);
    }

    // Export PDF dan simpan ke storage/public/pdf
    public function exportPdf($id)
    {
        $requestData = AssetRequest::findOrFail($id);

        $fileName = 'assetrequest_' . $requestData->id . '.pdf';
        $filePath = storage_path('app/public/pdf/' . $fileName);

        // Pastikan folder ada
        $folderPath = storage_path('app/public/pdf');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        // Simpan PDF ke storage
        $pdf = Pdf::loadView('backend.v_assetrequest.cetak', compact('requestData'));
        $pdf->save($filePath);

        // URL publik ke PDF
        $pdfUrl = asset('storage/pdf/' . $fileName);

        // Bisa stream sekaligus
        return $pdf->stream($fileName, ['Attachment' => false]);
    }

    // Cetak PDF dengan try/catch untuk aman
    public function cetakSafe($id)
    {
        $requestData = AssetRequest::findOrFail($id);

        try {
            $pdf = Pdf::loadView('backend.v_assetrequest.cetak', compact('requestData'));

            // Pastikan folder ada
            $folderPath = storage_path('app/public/pdf');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            $fileName = 'assetrequest_' . $requestData->id . '.pdf';
            $filePath = $folderPath . '/' . $fileName;

            $pdf->save($filePath);

            // URL publik
            $pdfUrl = asset('storage/pdf/' . $fileName);

            return $pdf->stream($fileName);

        } catch (\Exception $e) {
            \Log::error("Gagal cetak Asset Request: " . $e->getMessage());
            return redirect()->route('backend.assetrequest.index')
                             ->with('warning', 'Form berhasil disimpan, tapi cetak gagal.');
        }
    }

    // Hapus data permintaan asset
    public function destroy($id)
    {
        $requestData = AssetRequest::findOrFail($id);
        $requestData->delete();

        return redirect()
            ->route('backend.assetrequest.index')
            ->with('success', 'Formulir permintaan asset berhasil dihapus.');
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $requestData = AssetRequest::findOrFail($id);
        return view('backend.v_assetrequest.edit', compact('requestData'));
    }

    // Update data permintaan asset
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'request_type' => 'required|string|max:255',
            'request_type_extra'  => 'nullable|string|max:255',
            'request_ref_num' => 'nullable|string|max:255',
            'tipe_penyerahan' => 'required|string',
            'nik' => 'required|string|max:255',
            'dept' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'asset_type' => 'required|string|max:255',
            'details' => 'required|array',
            'details.*.brand' => 'required|string|max:255',
            'details.*.model' => 'required|string|max:255',
            'details.*.qty' => 'required|integer|min:1',
            'details.*.user_pic' => 'required|string|max:255',
            'tanggal_dokumen' => 'nullable|date',
            'tanggal_expired' => 'nullable|date',

            // tambahan
            'status'  => 'nullable|in:pending approval,approval,done',
            'catatan' => 'nullable|string',

        ]);

        $requestData = AssetRequest::findOrFail($id);

        $data = [
            'request_type'    => $validated['request_type'],
            'request_type_extra'  => $validated['request_type_extra'] ?? null,
            'request_ref_num' => $validated['request_ref_num'] ?? null,
            'tipe_penyerahan' => $validated['tipe_penyerahan'],
            'nik'             => $validated['nik'],
            'dept'            => $validated['dept'],
            'section'         => $validated['section'],
            'asset_type'      => $validated['asset_type'],
            'details'         => $validated['details'],
            'tanggal_dokumen'  => $validated['tanggal_dokumen'],
            'tanggal_expired'  => $validated['tanggal_expired'],

            // tambahan
            'status'  => $validated['status'] ?? $requestData->status,
            'catatan' => $validated['catatan'] ?? $requestData->catatan,
            
        ];

        // Kalau update tipe penyerahan = New Asset, cek/generate nomor baru hanya jika belum ada
        if ($validated['tipe_penyerahan'] == 'New Asset' && !$requestData->new_asset_number) {
            $dept = $validated['dept'] ?: null;
            $section = $validated['section'] ?: null;
            $ym = date('Ym');

            $sequence = AssetNumberSequence::firstOrCreate(
                [
                    'dept' => $dept,
                    'section' => $section,
                    'year_month' => $ym
                ],
                ['last_number' => 0]
            );

            $sequence->increment('last_number');

            $parts = [];
            if ($dept) $parts[] = $dept;
            if ($section) $parts[] = $section;
            $parts[] = 'NA';
            $parts[] = $ym;
            $parts[] = str_pad($sequence->last_number, 3, '0', STR_PAD_LEFT);

            $newAssetNumber = implode('-', $parts);
            $data['new_asset_number'] = $newAssetNumber;
        }

        try {
            $requestData->update($data);

            return redirect()
                ->route('backend.assetrequest.show', $requestData->id)
                ->with('success', 'Formulir permintaan asset berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error("Gagal update form permintaan: " . $e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

}

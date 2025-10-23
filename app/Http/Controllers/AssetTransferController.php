<?php

namespace App\Http\Controllers;

use App\Models\AssetTransfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class AssetTransferController extends Controller
{
    // Menampilkan daftar peralihan asset
    public function index()
    {
        $transfers = AssetTransfer::latest()->get();
        return view('backend.v_assettransfer.index', compact('transfers'));
    }

    // Menampilkan halaman buat peralihan baru
    public function create()
    {
        return view('backend.v_assettransfer.create');
    }

    // Menyimpan data peralihan asset
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Informasi Asset
            'asset_tag'           => 'nullable|string|max:255',
            'asset_brand'         => 'nullable|string|max:255',
            'asset_model'         => 'nullable|string|max:255',
            'category'            => 'nullable|string|max:255',
            'brand_model'         => 'nullable|string|max:255',
            'serial_number'       => 'nullable|string|max:255',
            'purchase_date'       => 'nullable|date',
            'purchase_price'      => 'nullable|string',
            'warranty_status'     => 'nullable|string|max:255',
            'warranty_end_date'   => 'nullable|date',
            'tanggal_dokumen'     => 'nullable|date',
            'tanggal_expired'     => 'nullable|date',

            // Sebelum Pengalihan
            'prev_department'     => 'nullable|string|max:255',
            'prev_user'           => 'nullable|string|max:255',
            'transfer_reason'     => 'nullable|string',

            // Sesudah Pengalihan
            'new_department'      => 'nullable|string|max:255',
            'new_user'            => 'nullable|string|max:255',
            'transfer_date'       => 'nullable|date',
            'placement_location'  => 'nullable|string|max:255',
            'asset_condition'     => 'nullable|string|max:255',

            // tambahan
            'status'  => 'nullable|in:pending approval,approval,done',
            'catatan' => 'nullable|string',
        ]);

        $purchasePrice = null;
        if ($request->purchase_price) {
            // Hapus titik ribuan: 1.000.000 -> 1000000
            $purchasePrice = str_replace('.', '', $request->purchase_price);

            // Pastikan float: 1000000 -> 1000000.00
            $purchasePrice = floatval($purchasePrice);
        }

        $data = [
            // Informasi asset
            'asset_tag'       => $validated['asset_tag'] ?? null,
            'asset_brand'     => $validated['asset_brand'] ?? null,
            'asset_model'     => $validated['asset_model'] ?? null,
            'asset_name'      => $validated['asset_brand'].' '.$validated['asset_model'], // gabungan brand + model
            'category'        => $validated['category'] ?? null,
            'serial_number'   => $validated['serial_number'] ?? null,
            'purchase_date'   => $validated['purchase_date'] ?? null,
            'purchase_price'  => $purchasePrice ?? null,
            'warranty_status' => $validated['warranty_status'] ?? null,
            'warranty_end_date' => $validated['warranty_end_date'] ?? null,
            'tanggal_dokumen' => $validated['tanggal_dokumen'] ?? null,
            'tanggal_expired' => $validated['tanggal_expired'] ?? null,

            // Sebelum pengalihan
            'prev_department' => $validated['prev_department'] ?? null,
            'prev_user'       => $validated['prev_user'] ?? null,
            'transfer_reason' => $validated['transfer_reason'] ?? null,

            // Sesudah pengalihan
            'new_department'     => $validated['new_department'] ?? null,
            'new_user'           => $validated['new_user'] ?? null,
            'transfer_date'      => $validated['transfer_date'] ?? null,
            'placement_location' => $validated['placement_location'] ?? null,
            'asset_condition'    => $validated['asset_condition'] ?? null,

            // tambahan
            'status'  => $validated['status'] ?? 'pending approval',
            'catatan' => $validated['catatan'] ?? null,
        ];

        try {
            $transfer = AssetTransfer::create($data);
            session(['transfer_id' => $transfer->id]);

            //Buat notifikasi untuk semua admin
            $admins = User::where('role', 0)->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'message' => Auth::user()->name . ' Mengajukan Form Peralihan Asset IT',
                    'link' => route('backend.assettransfer.index'),
                    'created_at' => now(), // tanggal & jam
                ]);
            }

            // Buat notifikasi untuk user pengirim
            Notification::create([
                'user_id'   => Auth::id(),
                'message'   => 'Form Peralihan Asset IT kamu berhasil dikirim',
                'link'      => route('backend.assettransfer.index'), // bisa diarahkan ke detail form juga
                'is_read'   => 0,
                'created_at'=> now(),
            ]);

            return redirect()
                ->back()
                ->with('success', 'Formulir peralihan berhasil diajukan!');
        } catch (\Exception $e) {
            \Log::error("Gagal simpan form peralihan: ".$e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    // Menampilkan detail peralihan asset
    public function show($id)
    {
        $transfer = AssetTransfer::findOrFail($id);
        return view('backend.v_assettransfer.show', compact('transfer'));
    }

    // Cetak / print peralihan asset
    public function cetakAssetTransfer($id)
    {
        $transfer = AssetTransfer::findOrFail($id);

        $data = [
            'judul' => 'Asset Transfer Form',
            'transfer' => $transfer
        ];

        $pdf = Pdf::loadView('backend.v_assettransfer.cetak', $data)
                  ->setPaper('a4', 'portrait');

        // Pastikan folder storage/pdf ada
        $folderPath = storage_path('app/public/pdf');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        // Nama file pakai format "Asset Transfer Form_ID.pdf"
        $fileName = 'Asset Transfer Form_' . $transfer->id . '.pdf';
        $pdf->save($folderPath . '/' . $fileName);

        // Stream ke browser
        return $pdf->stream($fileName);
    }

    // Export PDF dan dapatkan link publik
    public function exportPdf($id)
    {
        $transfer = AssetTransfer::findOrFail($id);

        $pdf = Pdf::loadView('backend.v_assettransfer.cetak', compact('transfer'));

        $fileName = 'assettransfer_' . $transfer->id . '.pdf';
        $filePath = storage_path('app/public/pdf/' . $fileName);

        $pdf->save($filePath);

        // URL publik ke PDF
        $pdfUrl = asset('storage/pdf/' . $fileName);

        // Kirim ke view jika perlu link publik
        $pdf = Pdf::loadView('backend.v_assettransfer.cetak', [
            'transfer' => $transfer,
            'pdfUrl' => $pdfUrl,
        ]);

        return $pdf->stream($fileName, [
            'Attachment' => false
        ]);
    }

    // Cetak aman, dengan handling error
    public function cetakSafe($id)
    {
        $transfer = AssetTransfer::findOrFail($id);

        try {
            $pdf = Pdf::loadView('backend.v_assettransfer.cetak', compact('transfer'));

            $folderPath = storage_path('app/public/pdf');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            $fileName = 'assettransfer_' . $transfer->id . '.pdf';
            $filePath = $folderPath . '/' . $fileName;

            $pdf->save($filePath);

            $pdfUrl = asset('storage/pdf/' . $fileName);

            return $pdf->stream($fileName);

        } catch (\Exception $e) {
            \Log::error("Gagal cetak Asset Transfer Form: " . $e->getMessage());
            return redirect()->route('backend.assettransfer.index')
                             ->with('warning', 'Form berhasil disimpan, tapi cetak gagal.');
        }
    }

    // Hapus data peralihan asset
    public function destroy($id)
    {
        $transfer = AssetTransfer::findOrFail($id);
        $transfer->delete();

        return redirect()
            ->route('backend.assettransfer.index')
            ->with('success', 'Formulir peralihan berhasil dihapus.');
    }

    // Menampilkan halaman edit peralihan asset
    public function edit($id)
    {
        $transfer = AssetTransfer::findOrFail($id);
        return view('backend.v_assettransfer.edit', compact('transfer'));
    }

    // Update data peralihan asset
    public function update(Request $request, $id)
    {
        $transfer = AssetTransfer::findOrFail($id);

        $validated = $request->validate([
            // Informasi Asset
            'asset_tag'           => 'nullable|string|max:255',
            'asset_brand'         => 'nullable|string|max:255',
            'asset_model'         => 'nullable|string|max:255',
            'category'            => 'nullable|string|max:255',
            'serial_number'       => 'nullable|string|max:255',
            'purchase_date'       => 'nullable|date',
            'purchase_price'      => 'nullable|string',
            'warranty_status'     => 'nullable|string|max:255',
            'warranty_end_date'   => 'nullable|date',
            'tanggal_dokumen'     => 'nullable|date',
            'tanggal_expired'     => 'nullable|date',

            // Sebelum Pengalihan
            'prev_department'     => 'nullable|string|max:255',
            'prev_user'           => 'nullable|string|max:255',
            'transfer_reason'     => 'nullable|string',

            // Sesudah Pengalihan
            'new_department'      => 'nullable|string|max:255',
            'new_user'            => 'nullable|string|max:255',
            'transfer_date'       => 'nullable|date',
            'placement_location'  => 'nullable|string|max:255',
            'asset_condition'     => 'nullable|string|max:255',

            // tambahan
            'status'  => 'nullable|in:pending approval,approval,done',
            'catatan' => 'nullable|string',
        ]);

        $purchasePrice = null;
        if ($request->purchase_price) {
            $purchasePrice = str_replace('.', '', $request->purchase_price);
            $purchasePrice = floatval($purchasePrice);
        }

        $data = [
            // Informasi asset
            'asset_tag'       => $validated['asset_tag'] ?? null,
            'asset_brand'     => $validated['asset_brand'] ?? null,
            'asset_model'     => $validated['asset_model'] ?? null,
            'asset_name'      => $validated['asset_brand'].' '.$validated['asset_model'] ?? null,
            'category'        => $validated['category'] ?? null,
            'serial_number'   => $validated['serial_number'] ?? null,
            'purchase_date'   => $validated['purchase_date'] ?? null,
            'purchase_price'  => $purchasePrice ?? null,
            'warranty_status' => $validated['warranty_status'] ?? null,
            'warranty_end_date' => $validated['warranty_end_date'] ?? null,
            'tanggal_dokumen' => $validated['tanggal_dokumen'] ?? null,
            'tanggal_expired' => $validated['tanggal_expired'] ?? null,

            // Sebelum pengalihan
            'prev_department' => $validated['prev_department'] ?? null,
            'prev_user'       => $validated['prev_user'] ?? null,
            'transfer_reason' => $validated['transfer_reason'] ?? null,

            // Sesudah pengalihan
            'new_department'     => $validated['new_department'] ?? null,
            'new_user'           => $validated['new_user'] ?? null,
            'transfer_date'      => $validated['transfer_date'] ?? null,
            'placement_location' => $validated['placement_location'] ?? null,
            'asset_condition'    => $validated['asset_condition'] ?? null,

            // tambahan
            'status'  => $validated['status'] ?? $requestData->status,
            'catatan' => $validated['catatan'] ?? $requestData->catatan,
        ];

        try {
            $transfer->update($data);

            return redirect()
                ->route('backend.assettransfer.index')
                ->with('success', 'Formulir peralihan berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error("Gagal update form peralihan: ".$e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

}

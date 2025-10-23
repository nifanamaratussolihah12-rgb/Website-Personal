<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NonAssetTicket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\Asset;
use App\Models\AssetMaintenance;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\AssetHistory;


class NonAssetTicketController extends Controller
{
    // 🔹 Menampilkan semua non-asset ticket
    public function index()
    {
        $nonAssetTickets = NonAssetTicket::latest()->get();
        return view('backend.v_nonassetticket.index', compact('nonAssetTickets'));
    }

    // 🔹 Form tambah ticket
    public function create()
    {
        $user = auth()->user();

        // Tentukan asset_kind untuk non-asset ticket
        $asset_kind = 'service';

        // 🔹 Ambil kategori sesuai role login & asset_kind = 'service'
        $kategoriQuery = Kategori::orderBy('nama_kategori', 'asc')
            ->where('asset_kind', $asset_kind);

        switch ($user->role) {
            case 1: // IT
                $kategoriQuery->where('owner_role', 'it');
                break;
            case 2: // GA
                $kategoriQuery->where('owner_role', 'ga');
                break;
        }

        $kategori = $kategoriQuery->get();
        $kategoriIds = $kategori->pluck('id'); // Ambil semua ID kategori yang tampil

        // 🔹 Ambil asset yang termasuk kategori yang user bisa lihat
        $assetQuery = Asset::orderBy('item_name')
            ->where('asset_kind', $asset_kind)
            ->whereIn('kategori_id', $kategoriIds); // Filter di sini

        switch ($user->role) {
            case 1: 
                $assetQuery->where('owner_role', 'it');
                break;
            case 2: 
                $assetQuery->where('owner_role', 'ga');
                break;
        }

        $asset = $assetQuery->get();

        //dd($asset->toArray());

        return view('backend.v_nonassetticket.create', [
            'asset' => $asset,
            'kategori' => $kategori,
            'asset_kind' => $asset_kind,
        ]);
    }

    // 🔹 Simpan ticket baru
    public function store(Request $request)
    {
        $request->validate([
            'subject'    => 'required|string|max:255',
            'category'   => 'required|string',
            'contact'    => 'required|string|min:4|max:13',
            'priority'   => 'nullable|in:Critical,High,Medium,Low',
            'status'     => 'nullable|in:Open,In Progress,Troubleshoot,Under Maintenance,Escalated,Resolved,Closed',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,txt|max:10240', // 10 MB
        ], [
            'attachment.max' => 'File seharusnya tidak lebih dari 10 megabyte.',  // <-- pesan custom
            'attachment.mimes' => 'Format file harus berupa jpg, jpeg, png, pdf, docx, atau txt.',
        ]);

        // 🔸 Generate nomor tiket otomatis
        $today = Carbon::now()->format('d-m-y');
        $countToday = NonAssetTicket::whereDate('created_at', Carbon::today())->count() + 1;
        $ticketNumber = sprintf('%s-%03d', $today, $countToday);

        // 🔸 Upload attachment jika ada
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $folder = public_path('non_asset_ticket_attachments');
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }
            $attachmentPath = $request->file('attachment')->store('non_asset_ticket_attachments', 'public');
        }

        // 🔸 Simpan data ticket
        $nonAssetTicket = NonAssetTicket::create([
            'asset_id'       => $request->asset_id,
            'ticket_number'  => $ticketNumber,
            'reporter_name'  => $request->reporter_name,
            'department'     => $request->department,
            'contact'        => $request->contact,
            'email'          => $request->email,
            'category'       => $request->category,
            'subject'        => $request->subject,
            'description'    => $request->description,
            'asset_name'     => $request->asset_name,
            'affected_users' => $request->affected_users,
            'location'       => $request->location,
            'priority'       => $request->priority,
            'attachment'     => $attachmentPath,
            'status'         => $request->status ?? 'Open',
        ]);

        // 🔹 Catat history otomatis (biar muncul di histori)
        AssetHistory::log(
            $nonAssetTicket->asset_id,
            'created',
            "Non-Asset Ticket baru dibuat #{$nonAssetTicket->ticket_number}",
            null,
            auth()->id(),
            null,
            null,
            $nonAssetTicket->status
        );

        // 🔹 Kalau statusnya Troubleshoot / Under Maintenance -> masuk ke tabel asset_maintenance
        if (in_array($nonAssetTicket->status, ['Troubleshoot', 'Under Maintenance'])) {
            AssetMaintenance::create([
                'non_asset_ticket_id'        => $nonAssetTicket->id, // pastikan kolom ini ada
                'asset_id'         => $nonAssetTicket->asset_id,
                'issue_date'       => now(),
                'maintenance_type' => $nonAssetTicket->status === 'Troubleshoot' ? 'corrective' : 'preventive',
                'priority'         => match($nonAssetTicket->priority) {
                    'Critical' => 'Top Urgent',
                    'High'     => 'Urgent',
                    'Medium'   => 'Medium',
                    default    => 'Low',
                },
                'handled_by'       => auth()->id(),
                'status'           => 'pending',
                'notes'            => 'Auto-generated from NonAssetTicket #' . $nonAssetTicket->ticket_number,
            ]);
        }

        return redirect()->route('backend.nonassetticket.index')
                         ->with('success', 'Non-Asset Ticket berhasil dibuat!');
    }

    // 🔹 Detail ticket
    public function show($id)
    {
        $nonAssetTicket = NonAssetTicket::with('asset')->findOrFail($id);
        return view('backend.v_nonassetticket.show', compact('ticket'));
    }

    // 🔹 Edit ticket
    public function edit($id)
    {
        $nonAssetTicket = NonAssetTicket::findOrFail($id);
        $user = auth()->user();

        // Non-asset ticket selalu pakai asset_kind = 'service'
        $asset_kind = 'service';

        // 🔹 Ambil kategori sesuai role & asset_kind = service
        $kategoriQuery = Kategori::orderBy('nama_kategori', 'asc')
            ->where('asset_kind', $asset_kind);

        switch ($user->role) {
            case 1: 
                $kategoriQuery->where('owner_role', 'it'); 
                break;
            case 2: 
                $kategoriQuery->where('owner_role', 'ga'); 
                break;
        }

        $kategori = $kategoriQuery->get();

        // 🔹 Ambil semua asset sesuai role & asset_kind = service (optional bisa dikosongkan)
        $assetQuery = Asset::with('kategori')
            ->orderBy('item_name', 'asc')
            ->where('asset_kind', $asset_kind);

        switch ($user->role) {
            case 1:  
                $assetQuery->where('owner_role', 'it'); 
                break;
            case 2: 
                $assetQuery->where('owner_role', 'ga'); 
                break;
        }

        $asset = $assetQuery->get()->map(function($a) {
            return [
                'id' => $a->id,
                'item_name' => $a->item_name,
                'room' => $a->room,
                'kategori_id' => $a->kategori ? $a->kategori->id : null,
            ];
        });

        return view('backend.v_nonassetticket.edit', compact('nonAssetTicket', 'kategori', 'asset', 'asset_kind'));
    }


    // 🔹 Update Non-Asset Ticket
    public function update(Request $request, $id)
    {
        $nonAssetTicket = NonAssetTicket::findOrFail($id);

        $request->validate([
            'subject'    => 'required|string|max:255',
            'category'   => 'required|string',
            'contact'    => 'required|string|min:4|max:13',
            'priority'   => 'nullable|in:Critical,High,Medium,Low',
            'status'     => 'nullable|in:Open,In Progress,Troubleshoot,Under Maintenance,Escalated,Resolved,Closed',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,txt|max:10240', // 10 MB
        ], [
            'attachment.max' => 'File seharusnya tidak lebih dari 10 megabyte.',  // <-- pesan custom
            'attachment.mimes' => 'Format file harus berupa jpg, jpeg, png, pdf, docx, atau txt.',
        ]);

        // 🔹 Handle attachment
        if ($request->hasFile('attachment')) {
            $folder = public_path('non_asset_ticket_attachments');
            if (!file_exists($folder)) mkdir($folder, 0755, true);

            if ($nonAssetTicket->attachment && Storage::disk('public')->exists($nonAssetTicket->attachment)) {
                Storage::disk('public')->delete($nonAssetTicket->attachment);
            }

            $nonAssetTicket->attachment = $request->file('attachment')->store('non_asset_ticket_attachments', 'public');
        }

        $originalStatus = $nonAssetTicket->getOriginal('status');

        // 🔹 Update data tiket
        $nonAssetTicket->fill($request->except('attachment'));
        $nonAssetTicket->status = $request->status;
        $nonAssetTicket->save();

        // 🔹 (opsional) Catat ke AssetHistory juga, tapi tanpa asset_id
        AssetHistory::log(
            null, // karena non-asset
            'updated',
            "Non-Asset Ticket #{$nonAssetTicket->ticket_number} diperbarui — status: {$nonAssetTicket->status}",
            null,
            auth()->id(),
            null,
            null,
            $nonAssetTicket->status
        );

        // 🔹 Jika status berubah ke Troubleshoot / Under Maintenance
        if (in_array($nonAssetTicket->status, ['Troubleshoot', 'Under Maintenance'])
            && $originalStatus !== $nonAssetTicket->status) {

            $existingMaintenance = AssetMaintenance::where('non_asset_ticket_id', $nonAssetTicket->id)->first();

            if (!$existingMaintenance) {
                AssetMaintenance::create([
                    'non_asset_ticket_id' => $nonAssetTicket->id,
                    'issue_date'          => now(),
                    'maintenance_type'    => $nonAssetTicket->status === 'Troubleshoot' ? 'corrective' : 'preventive',
                    'priority'            => match($nonAssetTicket->priority) {
                        'Critical' => 'Top Urgent',
                        'High'     => 'Urgent',
                        'Medium'   => 'Medium',
                        default    => 'Low',
                    },
                    'handled_by'          => auth()->id(),
                    'status'              => 'pending',
                    'notes'               => 'Auto-generated from Non-Asset Ticket #' . $nonAssetTicket->ticket_number,
                ]);
            }
        }

        return redirect()->route('backend.nonassetticket.index')
                        ->with('success', 'Non-Asset Ticket berhasil diperbarui!');
    }

    // 🔹 Hapus ticket
    public function destroy($id)
    {
        $nonAssetTicket = NonAssetTicket::findOrFail($id);
        if ($nonAssetTicket->attachment && Storage::disk('public')->exists($nonAssetTicket->attachment)) {
            Storage::disk('public')->delete($nonAssetTicket->attachment);
        }
        $nonAssetTicket->delete();

        return redirect()->route('backend.nonassetticket.index')
                         ->with('success', 'Non-Asset Ticket berhasil dihapus!');
    }

    public function getAssetByKategori($kategori_id)
    {
        $user = auth()->user();

        $query = \DB::table('asset_item_code')
            ->join('type_asset', 'asset_item_code.type_asset_id', '=', 'type_asset.id')
            ->join('kategori', 'asset_item_code.kategori_id', '=', 'kategori.id')
            ->select('asset_item_code.id', 'asset_item_code.item_name')
            ->where('kategori.id', $kategori_id);

        // filter sesuai role login
        switch ($user->role) {
            case 1: case 3: $query->where('type_asset.owner_role', 'it'); break;
            case 2: case 4: $query->where('type_asset.owner_role', 'ga'); break;
        }

        $asset = $query->orderBy('asset_item_code.item_name')->get();

        return response()->json($asset);
    }

    // 🔹 Cetak / Export Ticket ke PDF
    public function cetakNonAssetTicket($id)
    {
        $nonAssetTicket = NonAssetTicket::with('asset')->findOrFail($id);

        try {
            // Tentukan data untuk view PDF
            $data = [
                'judul' => 'Non Asset Ticket Form',
                'nonAssetTicket' => $nonAssetTicket,
            ];

            // Render PDF dari view Blade
            $pdf = Pdf::loadView('backend.v_nonassetticket.cetak', $data)
                ->setPaper('a4', 'portrait');

            // Pastikan folder penyimpanan ada
            $folderPath = storage_path('app/public/pdf');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            // Nama file contoh: "Non Asset Ticket Form_123.pdf"
            $fileName = 'Non Asset Ticket Form_' . $nonAssetTicket->id . '.pdf';
            $filePath = $folderPath . '/' . $fileName;

            // Simpan PDF ke storage/public/pdf
            $pdf->save($filePath);

            // URL publik ke file PDF
            $pdfUrl = asset('storage/pdf/' . $fileName);

            // Stream ke browser (tanpa download paksa)
            return $pdf->stream($fileName, ['Attachment' => false]);

        } catch (\Exception $e) {
            Log::error("Gagal mencetak Ticket ID {$id}: " . $e->getMessage());
            return redirect()->route('backend.nonassetticket.index')
                            ->with('warning', 'Data ticket berhasil disimpan, tapi cetak PDF gagal.');
        }
    }
}

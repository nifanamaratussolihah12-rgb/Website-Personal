<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\Asset;
use App\Models\AssetMaintenance;
use App\Models\Kategori;
use App\Models\NonAssetTicket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\AssetHistory;

class TicketController extends Controller
{
    // 🔹 Menampilkan semua ticket
    public function index()
    {
        $user = auth()->user();

        // 🧱 Inisialisasi query awal untuk kedua model
        $assetQuery = \App\Models\Ticket::with('asset')->orderBy('created_at', 'desc');
        $nonAssetQuery = \App\Models\NonAssetTicket::orderBy('created_at', 'desc');

        // 🔹 Filter berdasarkan role user
        if ($user) {
            switch ($user->role) {
                case 1: // Admin/Staff IT
                    $assetQuery->whereHas('asset', function ($q) {
                        $q->where('owner_role', 'it');
                    });
                    $nonAssetQuery->where('department', 'IT'); // karena non asset mungkin tidak punya relasi asset
                    break;

                case 2: // Admin/Staff GA
                    $assetQuery->whereHas('asset', function ($q) {
                        $q->where('owner_role', 'ga');
                    });
                    $nonAssetQuery->where('department', 'GA');
                    break;

                // Super Admin (role 0) => semua data
            }
        }

        // 🔹 Eksekusi query setelah filter
        $tickets = $assetQuery->get();
        $nonAssetTickets = $nonAssetQuery->get();

        // 🔹 Kirim data ke view utama
        return view('backend.v_ticket.index', [
            'judul' => 'Data Ticket',
            'tickets' => $tickets,
            'nonAssetTickets' => $nonAssetTickets,
        ]);
    }

    // 🔹 Form tambah ticket
    public function create(Request $request)
    {
        $user = auth()->user();

        // Tentukan asset_kind, misal default 'physical' untuk ticket asset
        $asset_kind = $request->asset_kind ?? 'physical';

        // 🔹 Ambil kategori sesuai role login & asset_kind
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

        // 🔹 Ambil semua asset sesuai role login & asset_kind
        $assetQuery = Asset::orderBy('item_name')
            ->where('asset_kind', $asset_kind);

        switch ($user->role) {
            case 1: 
                $assetQuery->where('owner_role', 'it');
                break;
            case 2: 
                $assetQuery->where('owner_role', 'ga');
                break;
        }
        $asset = $assetQuery->get();

        return view('backend.v_ticket.create', [
            'asset' => $asset,
            'kategori' => $kategori,
            'asset_kind' => $asset_kind,
        ]);
    }

    // 🔹 Simpan ticket baru
    public function store(Request $request)
    {
        //dd($request->all());
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


        // 🔸 Generate nomor otomatis
        $today = Carbon::now()->format('d-m-y');
        $countToday = Ticket::whereDate('created_at', Carbon::today())->count() + 1;
        $ticketNumber = sprintf('%s-%03d', $today, $countToday);

        // 🔸 Upload file jika ada, dan pastikan folder ada
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $folder = public_path('ticket_attachments');
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true); // buat folder kalau belum ada
            }
            $attachmentPath = $request->file('attachment')->store('ticket_attachments', 'public');
        }

        // 🔸 Simpan data ticket
        $ticket = Ticket::create([
            'ticket_number'  => $ticketNumber,
            'reporter_name'  => $request->reporter_name,
            'department'     => $request->department,
            'contact'        => $request->contact,
            'email'          => $request->email,
            'category'       => $request->category,
            'subject'        => $request->subject,
            'description'    => $request->description,
            'asset_id'       => $request->asset_id,
            'affected_users' => $request->affected_users,
            'location'       => $request->location,
            'priority'       => $request->priority,
            'attachment'     => $attachmentPath,
            'status'         => $request->status ?? 'Open',
        ]);

        // Catat history
        AssetHistory::log(
            $ticket->asset_id, // <-- ini harus asset tiket
            'created',
            "Ticket baru dibuat #{$ticket->ticket_number}",
            null,
            auth()->id(),
            null,
            null,
            $ticket->status
        );

        // 🔹 Kalau statusnya Troubleshoot / Under Maintenance -> masuk ke tabel asset_maintenance
        if (in_array($ticket->status, ['Troubleshoot', 'Under Maintenance'])) {
            AssetMaintenance::create([
                'ticket_id'        => $ticket->id, // pastikan kolom ini ada
                'asset_id'         => $ticket->asset_id,
                'issue_date'       => now(),
                'maintenance_type' => $ticket->status === 'Troubleshoot' ? 'corrective' : 'preventive',
                'priority'         => match($ticket->priority) {
                    'Critical' => 'Top Urgent',
                    'High'     => 'Urgent',
                    'Medium'   => 'Medium',
                    default    => 'Low',
                },
                'handled_by'       => auth()->id(),
                'status'           => 'pending',
                'notes'            => 'Auto-generated from Ticket #' . $ticket->ticket_number,
            ]);
        }

        return redirect()->route('backend.ticket.index')
                        ->with('success', 'Ticket berhasil dibuat!');
    }

    // 🔹 Menampilkan detail ticket
    public function show($id)
    {
        $ticket = Ticket::with('asset')->findOrFail($id);
        return view('backend.v_ticket.show', compact('ticket'));
    }

    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        $user = auth()->user();

        // Tentukan asset_kind dari tiket yang diedit (misal 'physical' atau 'service')
        $asset_kind = $ticket->asset_kind ?? 'physical'; // default ke 'physical' kalau null

        // 🔹 Ambil kategori sesuai role login & asset_kind
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

        // 🔹 Ambil semua asset sesuai role & asset_kind (opsional untuk service ticket bisa dikosongkan)
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

        return view('backend.v_ticket.edit', compact('ticket', 'kategori', 'asset', 'asset_kind'));
    }

    // 🔹 Update ticket
    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

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
            $folder = public_path('ticket_attachments');
            if (!file_exists($folder)) mkdir($folder, 0755, true);

            if ($ticket->attachment && Storage::disk('public')->exists($ticket->attachment)) {
                Storage::disk('public')->delete($ticket->attachment);
            }

            $ticket->attachment = $request->file('attachment')->store('ticket_attachments', 'public');
        }

        $originalStatus = $ticket->status;

        // 🔹 Update ticket fields
        $ticket->fill($request->except('attachment'));
        $ticket->status = $request->status;
        $ticket->save();

        // Catat history
            AssetHistory::log(
            $ticket->asset_id,
            'updated',
            "Ticket #{$ticket->ticket_number} diperbarui — status: {$ticket->status}",
            null,
            auth()->id(),
            null,
            null,
            $ticket->status
        );

        // 🔹 Handle AssetMaintenance
        $maintenance = AssetMaintenance::where('ticket_id', $ticket->id)->first();

        if (in_array($ticket->status, ['Troubleshoot', 'Under Maintenance'])) {
            $maintenanceData = [
                'asset_id'         => $ticket->asset_id,
                'maintenance_type' => $ticket->status === 'Troubleshoot' ? 'corrective' : 'preventive',
                'priority'         => match($ticket->priority) {
                    'Critical' => 'Top Urgent',
                    'High'     => 'Urgent',
                    'Medium'   => 'Medium',
                    default    => 'Low',
                },
                'status'           => 'pending',
                'notes'            => 'Auto-generated from Ticket #' . $ticket->ticket_number,
                'handled_by'       => auth()->id(),
            ];

            if ($maintenance) {
                // Update maintenance existing
                $maintenance->update($maintenanceData);
            } else {
                // Create new maintenance
                AssetMaintenance::create(array_merge($maintenanceData, [
                    'ticket_id'  => $ticket->id,
                    'issue_date' => now(),
                ]));
            }
        } else {
            // Opsional: hapus maintenance jika status ticket berubah ke non-trouble
            // $maintenance?->delete();
        }

        return redirect()->route('backend.ticket.index')
                        ->with('success', 'Ticket berhasil diperbarui!');
    }

    // 🔹 Hapus ticket
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        if ($ticket->attachment && Storage::disk('public')->exists($ticket->attachment)) {
            Storage::disk('public')->delete($ticket->attachment);
        }
        $ticket->delete();

        return redirect()->route('backend.ticket.index')
                         ->with('success', 'Ticket berhasil dihapus!');
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
            case 1: $query->where('type_asset.owner_role', 'it'); break;
            case 2: $query->where('type_asset.owner_role', 'ga'); break;
        }

        $asset = $query->orderBy('asset_item_code.item_name')->get();

        return response()->json($asset);
    }

    // 🔹 Cetak / Export Ticket ke PDF
    public function cetakTicket($id)
    {
        $ticket = Ticket::with('asset')->findOrFail($id);

        try {
            // Tentukan data untuk view PDF
            $data = [
                'judul' => 'Ticket Form',
                'ticket' => $ticket,
            ];

            // Render PDF dari view Blade (pastikan view-nya ada)
            $pdf = Pdf::loadView('backend.v_ticket.cetak', $data)
                ->setPaper('a4', 'portrait');

            // Pastikan folder penyimpanan ada
            $folderPath = storage_path('app/public/pdf');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            // Nama file contoh: "Ticket Form_123.pdf"
            $fileName = 'Ticket Form_' . $ticket->id . '.pdf';
            $filePath = $folderPath . '/' . $fileName;

            // Simpan PDF ke storage/public/pdf
            $pdf->save($filePath);

            // URL publik ke file PDF
            $pdfUrl = asset('storage/pdf/' . $fileName);

            // Stream ke browser (tanpa download paksa)
            return $pdf->stream($fileName, ['Attachment' => false]);

        } catch (\Exception $e) {
            Log::error("Gagal mencetak Ticket ID {$id}: " . $e->getMessage());
            return redirect()->route('backend.ticket.index')
                            ->with('warning', 'Data ticket berhasil disimpan, tapi cetak PDF gagal.');
        }
    }

}

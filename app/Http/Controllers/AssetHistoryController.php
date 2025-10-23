<?php

namespace App\Http\Controllers;

use App\Models\AssetHistory;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class AssetHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // pastikan user login
    }

    /**
     * Tampilkan daftar history sesuai role
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        // 🔹 Tentukan owner_role
        $ownerRole = match($user->role) {
            1 => 'it',   // Admin IT / Staff IT
            2 => 'ga',   // Admin GA / Staff GA
            default => null // Super Admin
        };

        // 🔹 Query history
        $query = AssetHistory::with(['asset','user'])->latest();

        if ($ownerRole) {
            // IT/GA hanya ambil history sesuai role
            $query->where('owner_role', $ownerRole);
        }

        // Filter tambahan
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('asset_id')) {
            $query->where('asset_id', $request->asset_id);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('description', 'like', "%{$s}%")
                  ->orWhere('action', 'like', "%{$s}%")
                  ->orWhereHas('asset', fn($q2) => $q2->where('item_name', 'like', "%{$s}%"))
                  ->orWhereHas('user', fn($q3) => $q3->where('nama', 'like', "%{$s}%")); // sesuaikan nama kolom user
            });
        }

        $allHistories = $query->get()
            ->unique(fn($h) => $h->asset_id . '-' . $h->action . '-' . ($h->status ?? ''))
            ->values();

        $page = $request->input('page', 1);
        $perPage = 15;

        $histories = new LengthAwarePaginator(
            $allHistories->forPage($page, $perPage),
            $allHistories->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('backend.v_assethistory.index', compact('histories'));
    }

    /**
     * Simpan history manual
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'asset_id' => 'nullable|exists:asset,id',
            'action' => 'required|string|max:50',
            'description' => 'nullable|string',
            'changes' => 'nullable|array',
            'retention_option' => 'nullable|in:3 hari,1 minggu,1 bulan',
        ]);

        $user = auth()->user();
        $ownerRole = match($user->role) {
            1 => 'it',
            2 => 'ga',
            default => null
        };

        // =========================
        // 🔹 Ticket (asset ticket)
        // =========================
        if (isset($request->ticket_id)) {
            $ticket = Ticket::find($request->ticket_id);
            if ($ticket) {
                $oldStatus = $ticket->getOriginal('status');
                $newStatus = $ticket->status;

                AssetHistory::log(
                    $ticket->asset_id,
                    'status_changed',
                    "Status Ticket #{$ticket->kode} berubah dari '{$oldStatus}' menjadi '{$newStatus}'",
                    ['from' => $oldStatus, 'to' => $newStatus],
                    auth()->id(),
                    null,
                    null,
                    $newStatus
                );
            }
        }

        // =========================
        // 🔹 NonAssetTicket
        // =========================
        if (isset($request->non_asset_ticket_id)) {
            $nonAssetTicket = NonAssetTicket::find($request->non_asset_ticket_id);
            if ($nonAssetTicket) {
                $oldStatus = $nonAssetTicket->getOriginal('status');
                $newStatus = $nonAssetTicket->status;

                AssetHistory::log(
                    null, // karena non asset, biasanya gak punya asset_id
                    'status_changed',
                    "Status Non-Asset Ticket #{$nonAssetTicket->kode} berubah dari '{$oldStatus}' menjadi '{$newStatus}'",
                    ['from' => $oldStatus, 'to' => $newStatus],
                    auth()->id(),
                    null,
                    null,
                    $newStatus
                );
            }
        }

        return redirect()->back()->with('success', 'History tersimpan.');
    }

    /**
     * Hapus history
     */
    public function destroy(AssetHistory $assetHistory)
    {
        $assetHistory->delete();
        return redirect()->back()->with('success', 'History dihapus.');
    }

    /**
     * Terapkan retention otomatis
     */
    public function applyRetention(Request $request)
    {
        $request->validate([
            'retention' => 'required|in:3,7,30',
        ]);

        $retentionMap = [
            '3'  => '3 hari',
            '7'  => '1 minggu',
            '30' => '1 bulan',
        ];

        $expiresAtMap = [
            '3'  => now()->addDays(3),
            '7'  => now()->addWeek(),
            '30' => now()->addMonth(),
        ];

        $user = auth()->user();
        $ownerRole = match($user->role) {
            1 => 'it',
            2 => 'ga',
            default => null
        };

        // update history sesuai role
        $query = AssetHistory::query();
        if ($ownerRole) {
            $query->where('owner_role', $ownerRole);
        }
        $query->update([
            'retention_option' => $retentionMap[$request->retention],
            'expires_at'       => $expiresAtMap[$request->retention],
        ]);

        // simpan setting retention per role
        \DB::table('settings')->updateOrInsert(
            ['key' => 'retention_days', 'owner_role' => $ownerRole],
            ['value' => $retentionMap[$request->retention]]
        );

        return redirect()->back()->with('success', 'Retention otomatis diterapkan.');
    }
}

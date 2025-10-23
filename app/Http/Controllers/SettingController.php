<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Tentukan owner_role sesuai user login
        $ownerRole = match($user->role) {
            1 => 'it',   // Admin IT / Staff IT
            2 => 'ga',   // Admin GA / Staff GA
            default => null // Super Admin
        };

        // Ambil setting retention sesuai role
        $settingsQuery = Setting::where('key', 'retention_days');

        if ($ownerRole) {
            // IT / GA: hanya ambil yang sesuai role
            $settingsQuery->where('owner_role', $ownerRole);
        } else {
            // Super Admin: ambil yang owner_role null
            $settingsQuery->whereNull('owner_role');
        }

        // Ambil satu entry terbaru (per role seharusnya cuma ada satu)
        $retention = $settingsQuery->latest('id')->first();

        return view('backend.settings.index', compact('retention'));
    }

}

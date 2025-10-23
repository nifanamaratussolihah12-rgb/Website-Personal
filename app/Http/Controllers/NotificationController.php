<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        // hanya ambil notifikasi milik user yg login
        $notifications = Notification::where('user_id', Auth::id())
                        ->where('is_read', 0)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('backend.v_notification.index', compact('notifications'));
    }

    public function read($id)
    {
        // hanya bisa baca notif miliknya sendiri
        $notif = Notification::where('user_id', Auth::id())
                    ->findOrFail($id);

        // update jadi sudah dibaca
        $notif->update(['is_read' => true]);

        // redirect ke link tujuan atau ke index
        return redirect($notif->link ?? route('backend.notification.index'));
    }

    public function destroy($id)
    {
        try {
            // hanya bisa hapus notif miliknya sendiri
            $notif = Notification::where('user_id', Auth::id())
                        ->findOrFail($id);

            $notif->delete();

            return redirect()->back()->with('success', 'Notifikasi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus notifikasi: ' . $e->getMessage()]);
        }
    }

    public function clear()
    {
        Notification::where('user_id', auth()->id())->delete();

        // langsung balik tanpa flash message biar clean
        return back();
    }

    public function clearAll()
    {
        // Hapus semua notifikasi milik user login
        Notification::where('user_id', auth()->id())->delete();

        return redirect()->back()->with('success', 'Semua notifikasi telah dihapus.');
    }

}

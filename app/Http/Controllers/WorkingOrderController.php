<?php

namespace App\Http\Controllers;

use App\Models\WorkingOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class WorkingOrderController extends Controller
{
    // Menampilkan daftar Working Order
    public function index()
    {
        $orders = WorkingOrder::latest()->get();
        return view('backend.v_workingorder.index', compact('orders'));
    }

    // Menampilkan halaman buat Working Order baru
    public function create()
    {
        return view('backend.v_workingorder.create');
    }

    // Menyimpan data Working Order
    public function store(Request $request)
    {
        $validated = $request->validate([
            //INI BAGIAN USER
            'nama' => 'required|string|max:255',
            'divisi' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'permintaan' => 'required|string',
            'jenis_pekerjaan' => 'required|in:jaringan,cctv,radio',
            'lokasi' => 'required|string|max:255',
            'details' => 'nullable|string',
            'dokumen_diterima' => 'nullable|string',
            'target_pengerjaan' => 'required|date',

            //INI BAGIAN IT
            'task_kesiapan_listrik' => 'nullable|string',
            'status_kesiapan_listrik' => 'nullable|in:ya,tidak',
            'reason_kesiapan_listrik' => 'nullable|string',
            'sign_kesiapan_listrik' => 'nullable|string',
            'task_tiang' => 'nullable|string',
            'status_tiang' => 'nullable|in:ya,tidak',
            'reason_tiang' => 'nullable|string',
            'sign_tiang' => 'nullable|string',
            'task_perangkat' => 'nullable|in:cctv,radio,jaringan',
            'status_perangkat' => 'nullable|in:ya,tidak',
            'reason_perangkat' => 'nullable|string',
            'sign_perangkat' => 'nullable|string',
            'task_panel' => 'nullable|string',
            'status_panel' => 'nullable|in:ya,tidak',
            'reason_panel' => 'nullable|string',
            'sign_panel' => 'nullable|string',
            'task_keselamatan' => 'nullable|array',
            'status_keselamatan' => 'nullable|array',
            'reason_keselamatan' => 'nullable|array',
            'sign_keselamatan' => 'nullable|array',
            'tanggal_dokumen' => 'nullable|date', 
            'tanggal_expired' => 'nullable|date', 

             // tambahan
            'status'  => 'nullable|in:pending approval,approval,done',
            'catatan' => 'nullable|string',
        ]);

        //dd($validated);  

        // Tambahkan tanggal otomatis
        $validated['tanggal'] = now()->format('Y-m-d');

        $validated['task_keselamatan'] = $request->task_keselamatan ?? [];
        $validated['status_keselamatan'] = $request->status_keselamatan ?? [];
        $validated['reason_keselamatan'] = $request->reason_keselamatan ?? [];
        $validated['sign_keselamatan'] = $request->sign_keselamatan ?? [];

        try {
            \DB::beginTransaction();

            // Simpan sekali saja
            $order = WorkingOrder::create($validated);

            \DB::commit();

            session(['working_order_id' => $order->id]);

            //Buat notifikasi untuk semua admin
            $admins = User::where('role', 0)->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'message' => Auth::user()->name . ' Mengajukan Form Working Order',
                    'link' => route('backend.workingorder.index'),
                    'created_at' => now(), // tanggal & jam
                ]);
            }

            // Buat notifikasi untuk user pengirim
            Notification::create([
                'user_id'   => Auth::id(),
                'message'   => 'Form Working Order kamu berhasil dikirim',
                'link'      => route('backend.workingorder.index'), // bisa diarahkan ke detail form juga
                'is_read'   => 0,
                'created_at'=> now(),
            ]);

            return redirect()->back()->with('success', 'Working Order berhasil dibuat!');
        } catch (\Throwable $e) {
            \DB::rollBack();
            dd([
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    // Menampilkan detail Working Order
    public function show($id)
    {
        $order = WorkingOrder::findOrFail($id);
        return view('backend.v_workingorder.show', compact('order'));
    }

    // Cetak / print Working Order
    public function cetakWorkingOrder($id)
    {
        $order = WorkingOrder::findOrFail($id);

        $data = [
            'judul' => 'Working Order',
            'order' => $order
        ];

        $pdf = Pdf::loadView('backend.v_workingorder.cetak', $data)
                  ->setPaper('a4', 'portrait');

        // Pastikan folder storage/pdf ada
        $folderPath = storage_path('app/public/pdf');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        // Nama file
        $fileName = 'Working Order_' . $order->id . '.pdf';
        $pdf->save($folderPath . '/' . $fileName);

        return $pdf->stream($fileName);
    }

    // Export PDF ke storage/public/pdf dan streaming
    public function exportPdf($id)
    {
        $order = WorkingOrder::findOrFail($id);

        $pdf = Pdf::loadView('backend.v_workingorder.cetak', compact('order'));

        $folderPath = storage_path('app/public/pdf');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        $fileName = 'working order_' . $order->id . '.pdf';
        $filePath = $folderPath . '/' . $fileName;

        $pdf->save($filePath);

        $pdfUrl = asset('storage/pdf/' . $fileName);

        // Bisa kirim URL ke view jika perlu
        $pdf = Pdf::loadView('backend.v_workingorder.cetak', [
            'order' => $order,
            'pdfUrl' => $pdfUrl
        ]);

        return $pdf->stream($fileName, ['Attachment' => false]);
    }

    // Cetak aman dengan try-catch
    public function cetakSafe($id)
    {
        $order = WorkingOrder::findOrFail($id);

        try {
            $pdf = Pdf::loadView('backend.v_workingorder.cetak', compact('order'));

            $folderPath = storage_path('app/public/pdf');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            $fileName = 'working order_' . $order->id . '.pdf';
            $filePath = $folderPath . '/' . $fileName;

            $pdf->save($filePath);

            return $pdf->stream($fileName);

        } catch (\Exception $e) {
            Log::error("Gagal cetak Working Order: " . $e->getMessage());
            return redirect()->route('backend.workingorder.index')
                             ->with('warning', 'Form berhasil disimpan, tapi cetak gagal.');
        }
    }

    // Hapus data Working Order
    public function destroy($id)
    {
        $order = WorkingOrder::findOrFail($id);
        $order->delete();

        return redirect()
            ->route('backend.workingorder.index')
            ->with('success', 'Working Order berhasil dihapus.');
    }

    // Menampilkan halaman edit Working Order
    public function edit($id)
    {
        $order = WorkingOrder::findOrFail($id);
        return view('backend.v_workingorder.edit', compact('order'));
    }

    // Update Working Order
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            //INI BAGIAN USER
            'nama' => 'required|string|max:255',
            'divisi' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'permintaan' => 'required|string',
            'jenis_pekerjaan' => 'required|in:jaringan,cctv,radio',
            'lokasi' => 'required|string|max:255',
            'details' => 'nullable|string',
            'dokumen_diterima' => 'nullable|string',
            'target_pengerjaan' => 'required|date',

            //INI BAGIAN IT
            'task_kesiapan_listrik' => 'nullable|string',
            'status_kesiapan_listrik' => 'nullable|in:ya,tidak',
            'reason_kesiapan_listrik' => 'nullable|string',
            'sign_kesiapan_listrik' => 'nullable|string',
            'task_tiang' => 'nullable|string',
            'status_tiang' => 'nullable|in:ya,tidak',
            'reason_tiang' => 'nullable|string',
            'sign_tiang' => 'nullable|string',
            'task_perangkat' => 'nullable|in:cctv,radio,jaringan',
            'status_perangkat' => 'nullable|in:ya,tidak',
            'reason_perangkat' => 'nullable|string',
            'sign_perangkat' => 'nullable|string',
            'task_panel' => 'nullable|string',
            'status_panel' => 'nullable|in:ya,tidak',
            'reason_panel' => 'nullable|string',
            'sign_panel' => 'nullable|string',
            'task_keselamatan' => 'nullable|array',
            'status_keselamatan' => 'nullable|array',
            'reason_keselamatan' => 'nullable|array',
            'sign_keselamatan' => 'nullable|array',
            'tanggal_dokumen' => 'nullable|date', 
            'tanggal_expired' => 'nullable|date', 

             // tambahan
            'status'  => 'nullable|in:pending approval,approval,done',
            'catatan' => 'nullable|string',
        ]);
        
        $validated['tanggal'] = now()->format('Y-m-d');

        // Pastikan array safety tasks tetap array kosong kalau null
        $validated['task_keselamatan'] = $request->task_keselamatan ?? [];
        $validated['status_keselamatan'] = $request->status_keselamatan ?? [];
        $validated['reason_keselamatan'] = $request->reason_keselamatan ?? [];
        $validated['sign_keselamatan'] = $request->sign_keselamatan ?? [];

        try {
            DB::beginTransaction();

            $order = WorkingOrder::findOrFail($id);

            $order->update(array_merge($validated, [
                'task_keselamatan' => $request->task_keselamatan ?? [],
                'status_keselamatan' => $request->status_keselamatan ?? [],
                'reason_keselamatan' => $request->reason_keselamatan ?? [],
                'sign_keselamatan' => $request->sign_keselamatan ?? [],
            ]));

            DB::commit();

            return redirect()
                ->route('backend.workingorder.show', $order->id)
                ->with('success', 'Working Order berhasil diperbarui!');
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return back()->with('error', 'Update gagal: '.$e->getMessage());
        }
    }

}

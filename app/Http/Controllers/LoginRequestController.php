<?php

namespace App\Http\Controllers;

use App\Models\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class LoginRequestController extends Controller
{
    // Menampilkan daftar Login Request
    public function index()
    {
        $loginRequests = LoginRequest::latest()->get();
        return view('backend.v_loginrequest.index', compact('loginRequests'));
    }

    // Menampilkan form create
    public function create()
    {
        return view('backend.v_loginrequest.create');
    }

    // Simpan data Login Request
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal'              => 'nullable|date',
            'cabang'               => 'nullable|string|max:255',
            'is_abm_group'         => 'nullable|string',
            'company_name'         => 'nullable|string|max:255',
            'jenis_permintaan'     => 'nullable|in:email,internet',
            'sub_jenis'            => 'nullable|string|max:255',
            'nama_depan'           => 'nullable|string|max:255',
            'nama_tengah'          => 'nullable|string|max:255',
            'nama_belakang'        => 'nullable|string|max:255',
            'nik'                  => 'nullable|string|max:100',
            'alamat_email'         => 'nullable|string|max:255',
            'divisi'               => 'nullable|string|max:255',
            'departemen'           => 'nullable|string|max:255',
            'note'                 => 'nullable|string|max:500',
            'mengetahui'           => 'nullable|string|max:255',
            'tanggal_diterima'     => 'nullable|date',
            'alamat_email_login'   => 'nullable|string|max:255',
            'password'             => 'nullable|string',
            'tanggal_efektif'      => 'nullable|date',
            'dibuat_oleh'          => 'nullable|string|max:255',
            'tanggal_dibuat'       => 'nullable|date',
            'catatan'              => 'nullable|string|max:500',
            'tanggal_dokumen'      => 'nullable|date',
            'tanggal_expired'      => 'nullable|date',

            // tambahan
            'status'  => 'nullable|in:pending approval,approval,done',
            'memo' => 'nullable|string',
        ]);

        //dd($validated);

        // Gabungkan company_name
        if ($request->filled('is_abm_group')) {
            if ($request->is_abm_group == '1' && $request->filled('company_abm')) {
                $validated['company_name'] = 'PT ' . strtoupper($request->company_abm) . ' / ABM Group';
            } elseif ($request->is_abm_group == '0' && $request->filled('company_other')) {
                $validated['company_name'] = $request->company_other;
            } else {
                $validated['company_name'] = null;
            }
        }

        // Gabungkan sub_jenis
        if ($request->filled('jenis_permintaan')) {
            if ($request->jenis_permintaan == 'email' && $request->filled('sub_jenis_email')) {
                $validated['sub_jenis'] = $request->sub_jenis_email;
            } elseif ($request->jenis_permintaan == 'internet' && $request->filled('sub_jenis_internet')) {
                $validated['sub_jenis'] = $request->sub_jenis_internet;
            }
        }

         // Enkripsi password jika diisi
       if (!$request->filled('password')) {
            unset($validated['password']); // kosong → jangan ubah password lama
        }

        try {
            $loginRequest = LoginRequest::create($validated);

            session(['login_request_id' => $loginRequest->id]);

            // Notifikasi untuk semua admin
            $admins = User::where('role', 0)->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'message' => Auth::user()->name . ' Mengajukan Form Permintaan Login Email / Internet',
                    'link' => route('backend.loginrequest.index'),
                    'created_at' => now(),
                ]);
            }

            // Notifikasi untuk user pengirim
            Notification::create([
                'user_id'    => Auth::id(),
                'message'    => 'Form Permintaan Login Email / Internet kamu berhasil dikirim',
                'link'       => route('backend.loginrequest.index'),
                'is_read'    => 0,
                'created_at' => now(),
            ]);

            return redirect()
                ->back()
                ->with('success', 'Login Request berhasil disimpan!');
        } catch (\Exception $e) {
            Log::error("Gagal simpan Login Request: " . $e->getMessage());

            return redirect()
                ->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    // Detail Login Request
    public function show($id)
    {
        $loginRequest = LoginRequest::findOrFail($id);
        return view('backend.v_loginrequest.show', compact('loginRequest'));
    }

    // Cetak Login Request (PDF)
public function cetakLoginRequest($id)
{
    $loginRequest = LoginRequest::findOrFail($id);

    // 🔑 Dekripsi password sebelum dikirim ke view
    if ($loginRequest->password) {
        try {
            $loginRequest->password = Crypt::decrypt($loginRequest->password);
        } catch (\Exception $e) {
            // Kalau gagal dekripsi
            $loginRequest->password = '[invalid data]';
        }
    } else {
        $loginRequest->password = '-';
    }

    $data = [
        'judul' => 'Login Request',
        'loginRequest' => $loginRequest,
    ];

    $pdf = Pdf::loadView('backend.v_loginrequest.cetak', $data)
            ->setPaper('a4', 'portrait');

    return $pdf->stream('Login Request_' . $loginRequest->id . '.pdf');
}


    // Export PDF dengan link public
    public function exportPdf($id)
    {
        $loginRequest = LoginRequest::findOrFail($id);

        $pdf = Pdf::loadView('pdf.loginrequest', compact('loginRequest'));

        $fileName = 'Login Request_' . $loginRequest->id . '.pdf';
        $filePath = storage_path('app/public/pdf/' . $fileName);

        $pdf->save($filePath);

        $pdfUrl = asset('storage/pdf/' . $fileName);

        return $pdf->stream($fileName, [
            'Attachment' => false
        ]);
    }

    // Cetak dengan safe mode
    public function cetakSafe($id)
    {
        $loginRequest = LoginRequest::findOrFail($id);

        try {
            $pdf = Pdf::loadView('pdf.loginrequest', compact('loginRequest'));

            $folderPath = storage_path('app/public/pdf');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            $fileName = 'Login Request_' . $loginRequest->id . '.pdf';
            $filePath = $folderPath . '/' . $fileName;

            $pdf->save($filePath);

            return $pdf->stream($fileName);

        } catch (\Exception $e) {
            Log::error("Gagal cetak Login Request: " . $e->getMessage());
            return redirect()->route('loginrequest.index')
                            ->with('warning', 'Data berhasil disimpan, tapi cetak gagal.');
        }
    }

    // Hapus data Login Request
    public function destroy($id)
    {
        $loginRequest = LoginRequest::findOrFail($id);
        $loginRequest->delete();

        return redirect()
            ->route('backend.loginrequest.index')
            ->with('success', 'Login Request berhasil dihapus.');
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $loginRequest = LoginRequest::findOrFail($id);

        return view('backend.v_loginrequest.edit', compact('loginRequest'));
    }

    // Update data Login Request
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tanggal'              => 'nullable|date',
            'cabang'               => 'nullable|string|max:255',
            'is_abm_group'         => 'nullable|string',
            'company_name'         => 'nullable|string|max:255',
            'jenis_permintaan'     => 'nullable|in:email,internet',
            'sub_jenis'            => 'nullable|string|max:255',
            'nama_depan'           => 'nullable|string|max:255',
            'nama_tengah'          => 'nullable|string|max:255',
            'nama_belakang'        => 'nullable|string|max:255',
            'nik'                  => 'nullable|string|max:100',
            'alamat_email'         => 'nullable|string|max:255',
            'divisi'               => 'nullable|string|max:255',
            'departemen'           => 'nullable|string|max:255',
            'note'                 => 'nullable|string|max:500',
            'mengetahui'           => 'nullable|string|max:255',
            'tanggal_diterima'     => 'nullable|date',
            'alamat_email_login'   => 'nullable|string|max:255',
            'password'             => 'nullable|string',
            'tanggal_efektif'      => 'nullable|date',
            'dibuat_oleh'          => 'nullable|string|max:255',
            'tanggal_dibuat'       => 'nullable|date',
            'catatan'              => 'nullable|string|max:500',
            'tanggal_dokumen'      => 'nullable|date',
            'tanggal_expired'      => 'nullable|date',

            // tambahan
            'status'  => 'nullable|in:pending approval,approval,done',
            'memo' => 'nullable|string',
        ]);

        // Gabungkan company_name
        if ($request->filled('is_abm_group')) {
            if ($request->is_abm_group == '1' && $request->filled('company_abm')) {
                $validated['company_name'] = 'PT ' . strtoupper($request->company_abm) . ' / ABM Group';
            } elseif ($request->is_abm_group == '0' && $request->filled('company_other')) {
                $validated['company_name'] = $request->company_other;
            } else {
                $validated['company_name'] = null;
            }
        }

        // Gabungkan sub_jenis
        if ($request->filled('jenis_permintaan')) {
            if ($request->jenis_permintaan == 'email' && $request->filled('sub_jenis_email')) {
                $validated['sub_jenis'] = $request->sub_jenis_email;
            } elseif ($request->jenis_permintaan == 'internet' && $request->filled('sub_jenis_internet')) {
                $validated['sub_jenis'] = $request->sub_jenis_internet;
            }
        }

        // Enkripsi password jika diisi
       if (!$request->filled('password')) {
            unset($validated['password']); // kosong → jangan ubah password lama
        }


        try {
            $loginRequest = LoginRequest::findOrFail($id);
            $loginRequest->update($validated);

            return redirect()
                ->route('backend.loginrequest.index')
                ->with('success', 'Login Request berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error("Gagal update Login Request: " . $e->getMessage());

            return redirect()
                ->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

}

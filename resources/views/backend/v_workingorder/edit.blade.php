@extends('backend.v_layouts.app')

@section('content')
<div class="container">
    <div class="card shadow rounded-3">
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0">✏️ Edit Formulir Working Order</h4>
        </div>
        <div class="card-body">

            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    <br>
                    <a href="{{ route('backend.workingorder.cetak', $order->id) }}" target="_blank" class="btn btn-success mt-2">
                        Cetak Form
                    </a>
                </div>
            @endif

            <form action="{{ route('backend.workingorder.update', $order->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Bagian User --}}
                <h5 class="mt-3 text-decoration-underline">Bagian ini diisi oleh User</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="nama" class="form-label">{!! fieldLabel('Nama', $order->nama) !!}</label>
                        <input type="text" name="nama" id="nama" class="form-control border border-dark"
                            value="{{ old('nama', $order->nama) }}" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="divisi" class="form-label">{!! fieldLabel('Divisi', $order->divisi) !!}</label>
                        <input type="text" name="divisi" id="divisi" class="form-control border border-dark"
                            value="{{ old('divisi', $order->divisi) }}" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="section" class="form-label">{!! fieldLabel('Section', $order->section) !!}</label>
                        <input type="text" name="section" id="section" class="form-control border border-dark"
                            value="{{ old('section', $order->section) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="permintaan" class="form-label">{!! fieldLabel('Permintaan', $order->permintaan) !!}</label>
                        <textarea name="permintaan" id="permintaan" class="form-control border border-dark" rows="2">{{ old('permintaan', $order->permintaan) }}</textarea>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="jenis_pekerjaan" class="form-label">{!! fieldLabel('Jenis Pekerjaan', $order->jenis_pekerjaan) !!}</label>
                        <select name="jenis_pekerjaan" id="jenis_pekerjaan" class="form-control border border-dark" required>
                            <option value="">-- Pilih --</option>
                            <option value="jaringan" {{ old('jenis_pekerjaan', $order->jenis_pekerjaan) == 'jaringan' ? 'selected' : '' }}>Jaringan</option>
                            <option value="cctv" {{ old('jenis_pekerjaan', $order->jenis_pekerjaan) == 'cctv' ? 'selected' : '' }}>CCTV</option>
                            <option value="radio" {{ old('jenis_pekerjaan', $order->jenis_pekerjaan) == 'radio' ? 'selected' : '' }}>Radio</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="lokasi" class="form-label">{!! fieldLabel('Lokasi', $order->lokasi) !!}</label>
                        <input type="text" name="lokasi" id="lokasi" class="form-control border border-dark"
                            value="{{ old('lokasi', $order->lokasi) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="details" class="form-label">{!! fieldLabel('Details', $order->details) !!}</label>
                        <textarea name="details" id="details" class="form-control border border-dark" rows="2">{{ old('details', $order->details) }}</textarea>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="dokumen_diterima" class="form-label">{!! fieldLabel('Dokumen Diterima', $order->dokumen_diterima) !!}</label>
                        <input type="text" name="dokumen_diterima" id="dokumen_diterima" class="form-control border border-dark"
                            value="{{ old('dokumen_diterima', $order->dokumen_diterima) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="target_pengerjaan" class="form-label">{!! fieldLabel('Target Pengerjaan', $order->target_pengerjaan) !!}</label>
                        <input type="date" name="target_pengerjaan" id="target_pengerjaan" class="form-control border border-dark"
                            value="{{ old('target_pengerjaan', $order->target_pengerjaan?->format('Y-m-d')) }}" required>
                    </div>
                </div>

                {{-- Bagian Checklist --}}
                <h5 class="mt-4 text-decoration-underline">IT & SI Preparation Checklist</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>Status</th>
                            <th>Reason</th>
                            <th>Sign</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- 1. Kesiapan Instalasi Listrik --}}
                        <tr>
                            <td><strong>{!! fieldLabel('Kesiapan instalasi listrik', $order->status_kesiapan_listrik) !!}</strong></td>
                            <td>
                                <select name="status_kesiapan_listrik" class="form-control border border-dark">
                                    <option value="">-- Pilih --</option>
                                    <option value="ya" {{ old('status_kesiapan_listrik', $order->status_kesiapan_listrik) == 'ya' ? 'selected' : '' }}>Ya</option>
                                    <option value="tidak" {{ old('status_kesiapan_listrik', $order->status_kesiapan_listrik) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                </select>
                            </td>
                            <td><input type="text" name="reason_kesiapan_listrik" class="form-control border border-dark"
                                value="{{ old('reason_kesiapan_listrik', $order->reason_kesiapan_listrik) }}"></td>
                            <td><input type="text" name="sign_kesiapan_listrik" class="form-control border border-dark"
                                value="{{ old('sign_kesiapan_listrik', $order->sign_kesiapan_listrik) }}"></td>
                        </tr>

                        {{-- 2. Tiang --}}
                        <tr>
                            <td><strong>{!! fieldLabel('Tiang', $order->status_tiang) !!}</strong></td>
                            <td>
                                <select name="status_tiang" class="form-control border border-dark">
                                    <option value="">-- Pilih --</option>
                                    <option value="ya" {{ old('status_tiang', $order->status_tiang) == 'ya' ? 'selected' : '' }}>Ya</option>
                                    <option value="tidak" {{ old('status_tiang', $order->status_tiang) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                </select>
                            </td>
                            <td><input type="text" name="reason_tiang" class="form-control border border-dark"
                                value="{{ old('reason_tiang', $order->reason_tiang) }}"></td>
                            <td><input type="text" name="sign_tiang" class="form-control border border-dark"
                                value="{{ old('sign_tiang', $order->sign_tiang) }}"></td>
                        </tr>

                        {{-- 3. Perangkat --}}
                        <tr>
                            <td>
                                <select name="task_perangkat" class="form-control border border-dark">
                                    <option value="">-- Pilih --</option>
                                    <option value="cctv" {{ old('task_perangkat', $order->task_perangkat) == 'cctv' ? 'selected' : '' }}>CCTV</option>
                                    <option value="radio" {{ old('task_perangkat', $order->task_perangkat) == 'radio' ? 'selected' : '' }}>Radio</option>
                                    <option value="jaringan" {{ old('task_perangkat', $order->task_perangkat) == 'jaringan' ? 'selected' : '' }}>Jaringan</option>
                                </select>
                            </td>
                            <td>
                                <select name="status_perangkat" class="form-control border border-dark">
                                    <option value="">-- Pilih --</option>
                                    <option value="ya" {{ old('status_perangkat', $order->status_perangkat) == 'ya' ? 'selected' : '' }}>Ya</option>
                                    <option value="tidak" {{ old('status_perangkat', $order->status_perangkat) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                </select>
                            </td>
                            <td><input type="text" name="reason_perangkat" class="form-control border border-dark"
                                value="{{ old('reason_perangkat', $order->reason_perangkat) }}"></td>
                            <td><input type="text" name="sign_perangkat" class="form-control border border-dark"
                                value="{{ old('sign_perangkat', $order->sign_perangkat) }}"></td>
                        </tr>

                        {{-- 4. Panel --}}
                        <tr>
                            <td><strong>{!! fieldLabel('Panel', $order->status_panel) !!}</strong></td>
                            <td>
                                <select name="status_panel" class="form-control border border-dark">
                                    <option value="">-- Pilih --</option>
                                    <option value="ya" {{ old('status_panel', $order->status_panel) == 'ya' ? 'selected' : '' }}>Ya</option>
                                    <option value="tidak" {{ old('status_panel', $order->status_panel) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                </select>
                            </td>
                            <td><input type="text" name="reason_panel" class="form-control border border-dark"
                                value="{{ old('reason_panel', $order->reason_panel) }}"></td>
                            <td><input type="text" name="sign_panel" class="form-control border border-dark"
                                value="{{ old('sign_panel', $order->sign_panel) }}"></td>
                        </tr>
                        
                        {{-- Baris khusus Keselamatan Kerja --}}
                        <tr>
                            <td><strong>Keselamatan Kerja</strong></td>
                            <td>
                                <select name="status_keselamatan[]" class="form-control border border-dark">
                                    <option value="">-- Pilih --</option>
                                    <option value="ya" {{ old('status_keselamatan.0', $order->status_keselamatan[0] ?? '') == 'ya' ? 'selected' : '' }}>Ya</option>
                                    <option value="tidak" {{ old('status_keselamatan.0', $order->status_keselamatan[0] ?? '') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="reason_keselamatan[]" class="form-control border border-dark"
                                    value="{{ old('reason_keselamatan.0', $order->reason_keselamatan[0] ?? '') }}">
                            </td>
                            <td>
                                <input type="text" name="sign_keselamatan[]" class="form-control border border-dark"
                                    value="{{ old('sign_keselamatan.0', $order->sign_keselamatan[0] ?? '') }}">
                            </td>
                        </tr>

                        {{-- Looping 6 baris manual --}}
                        @for($i = 0; $i < 6; $i++)
                        <tr>
                            <td>
                                <input type="text" name="task_keselamatan[]" class="form-control border border-dark"
                                    placeholder="{{ ($i+1).'. ...' }}"
                                    value="{{ old('task_keselamatan.'.$i, $order->task_keselamatan[$i] ?? '') }}">
                            </td>
                            <td>
                                <select name="status_keselamatan[]" class="form-control border border-dark">
                                    <option value="">-- Pilih --</option>
                                    <option value="ya" {{ old('status_keselamatan.'.($i+1), $order->status_keselamatan[$i+1] ?? '') == 'ya' ? 'selected' : '' }}>Ya</option>
                                    <option value="tidak" {{ old('status_keselamatan.'.($i+1), $order->status_keselamatan[$i+1] ?? '') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="reason_keselamatan[]" class="form-control border border-dark"
                                    value="{{ old('reason_keselamatan.'.($i+1), $order->reason_keselamatan[$i+1] ?? '') }}">
                            </td>
                            <td>
                                <input type="text" name="sign_keselamatan[]" class="form-control border border-dark"
                                    value="{{ old('sign_keselamatan.'.($i+1), $order->sign_keselamatan[$i+1] ?? '') }}">
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="tanggal_dokumen" class="form-label">{!! fieldLabel('Tanggal Dokumen Diterbitkan', $order->tanggal_dokumen) !!}</label>
                        <input type="date" name="tanggal_dokumen" id="tanggal_dokumen" class="form-control border border-dark"
                            value="{{ old('tanggal_dokumen', $order->tanggal_dokumen?->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tanggal_expired" class="form-label">{!! fieldLabel('Tanggal Dokumen Diterbitkan', $order->tanggal_expired) !!}</label>
                        <input type="date" name="tanggal_expired" id="tanggal_expired" class="form-control border border-dark"
                            value="{{ old('tanggal_expired', $order->tanggal_expired?->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="status" class="form-label">{!! fieldLabel('Status', $order->status) !!}</label>
                        <select name="status" id="status" class="form-select border border-dark">
                            <option value="">-- Pilih Item --</option>
                            <option value="pending approval" {{ old('status', $order->status) == 'pending approval' ? 'selected' : '' }}>Pending Approval</option>
                            <option value="approval" {{ old('status', $order->status) == 'approval' ? 'selected' : '' }}>Approval</option>
                            <option value="done" {{ old('status', $order->status) == 'done' ? 'selected' : '' }}>Done</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="catatan" class="form-label">{!! fieldLabel('Catatan', $order->catatan) !!}</label>
                        <textarea name="catatan" id="catatan" rows="3" class="form-control border border-dark"
                            placeholder="Tambahkan catatan jika ada">{{ old('catatan', $order->catatan) }}</textarea>
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Tombol Kembali --}}
<div class="text-center mt-3">
    <a href="{{ route('backend.workingorder.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection

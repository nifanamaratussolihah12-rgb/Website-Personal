@extends('backend.v_layouts.app')
@section('content')
<!-- contentAwal -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="fas fa-user-circle"></i> Profil
                </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Tabel di kiri -->
                    <div class="col-md-8">
                        <table class="table table-bordered">
                            <tr>
                                <th>Nama</th>
                                <td>{{ $user->nama }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td>
                                    @switch($user->role)
                                        @case(0)
                                            <span class="badge badge-warning">Super Admin</span>
                                            @break
                                        @case(1)
                                            <span class="badge badge-primary">Admin IT</span>
                                            @break
                                        @case(2)
                                            <span class="badge badge-success">Admin GA</span>
                                            @break
                                        @case(3)
                                            <span class="badge badge-info">Staff</span>
                                            @break
                                        @default
                                            <span class="badge badge-dark">Unknown</span>
                                    @endswitch
                                </td>
                            </tr>
                            <tr>
                                <th>HP</th>
                                <td>{{ $user->hp }}</td>
                            </tr>
                            <tr>
                                <th>NIK</th>
                                <td>{{ $user->nik ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Divisi</th>
                                <td>{{ $user->divisi ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Site</th>
                                <td>{{ $user->site ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Date of Receive</th>
                                <td>{{ $user->date_of_receive ? \Carbon\Carbon::parse($user->date_of_receive)->format('d-m-Y') : '-' }}</td>
                            </tr>
                        </table>
                        <a href="{{ $user->role == 3 ? route('backend.beranda') : route('backend.user.index') }}"
                        class="btn btn-secondary mt-3">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <!-- Foto di kanan -->
                    <div class="col-md-4 text-center">
                        <h5>{{ $user->nama }}</h5>
                        @if($user->foto)
                            <img src="{{ asset('storage/img-user/'.$user->foto) }}" class="img-fluid img-thumbnail mt-2">
                        @else
                            <span class="text-muted">Tidak ada foto</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- contentAkhir -->
@endsection

@extends('backend.v_layouts.app')
@section('content')
<div class="card shadow-sm border-0">

    <!-- Judul -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">
            <i class="mdi mdi-bell-ring text-warning me-2"></i> Daftar Notifikasi
        </h4>

        <div class="d-flex align-items-center">
        <!-- Tombol Kembali -->
        <a href="{{ route('backend.beranda') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>

        <!-- Spacer -->
        <div style="width: 10px;"></div> <!-- jarak 10px -->

        <!-- Hapus Semua -->
        <form action="{{ route('backend.notification.clearAll') }}" method="POST" style="margin:0;">
            @csrf
            <button type="submit" class="btn btn-sm btn-danger">
                <i class="fas fa-trash"></i> Clear All
            </button>
        </form>
    </div>
    </div>

    <!-- Card Notifikasi -->
    <div class="card shadow-sm rounded-3">
        <div class="card-body">
            @if($notifications->count() > 0)
                <div class="list-group">
                    @foreach($notifications as $notif)
                        <div class="list-group-item d-flex justify-content-between align-items-center mb-2 
                                    {{ $notif->is_read ? '' : 'bg-light' }}" 
                             style="border-radius: 6px;">

                            <!-- Pesan -->
                            <div>
                                <div class="fw-semibold">{{ $notif->message }}</div>
                                <small class="text-muted">
                                    <i class="far fa-clock me-1"></i>
                                    {{ $notif->created_at->format('d M Y H:i') }}
                                </small>
                            </div>

                            <!-- Aksi -->
                            <div class="d-flex align-items-center gap-2">
                                <!-- Tombol lihat -->
                                <a href="{{ route('backend.notification.read', $notif->id) }}" 
                                class="btn btn-sm btn-outline-primary" 
                                title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <!-- Tombol hapus -->
                                <form action="{{ route('backend.notification.destroy', $notif->id) }}" 
                                    method="POST" 
                                    onsubmit="return confirm('Yakin mau hapus notifikasi ini?');" 
                                    style="margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info mb-0">
                    <i class="mdi mdi-information-outline me-2"></i> Tidak ada notifikasi.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
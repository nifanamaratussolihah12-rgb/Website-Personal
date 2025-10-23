@extends('backend.v_layouts.app')

@section('content')
<div class="container mt-4">
    <h4 class="d-flex align-items-center">📝 Edit Ticket #{{ $ticket->ticket_number }}</h4>
    <hr>

    <form action="{{ route('backend.ticket.update', $ticket->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Informasi Pelapor --}}
        <div class="card mb-3 shadow-sm border-0">
            <div class="card-header bg-light fw-bold">
                <i class="fas fa-user me-1"></i> Informasi Pelapor
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label>Nama Pelapor</label>
                        <input type="text" name="reporter_name" class="form-control" value="{{ old('reporter_name', $ticket->reporter_name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label>Departemen</label>
                        <input type="text" name="department" class="form-control" value="{{ old('department', $ticket->department) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="contact" class="form-label">Kontak (Telp/WA)</label>
                        <input 
                            type="text" 
                            id="contact"
                            name="contact" 
                            value="{{ old('contact', $ticket->contact) }}" 
                            class="form-control @error('contact') is-invalid @enderror">

                        @error('contact')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $ticket->email) }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail Masalah --}}
        <div class="card mb-3 shadow-sm border-0">
            <div class="card-header bg-light fw-bold">
                <i class="fas fa-exclamation-triangle me-1"></i> Detail Masalah
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label>Kategori</label>
                        <select name="category" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            @foreach(['Hardware','Software','Network','Printer','Account/Email','Other'] as $category)
                                <option value="{{ $category }}" {{ $ticket->category == $category ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Subjek Masalah</label>
                        <input type="text" name="subject" class="form-control" value="{{ old('subject', $ticket->subject) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label>Deskripsi</label>
                        <textarea name="description" rows="2" class="form-control" required>{{ old('description', $ticket->description) }}</textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="attachment" class="form-label">Lampiran</label><br>

                        @if($ticket->attachment)
                            <a href="{{ asset('storage/'.$ticket->attachment) }}" target="_blank" class="btn btn-sm btn-outline-info mb-2">
                                <i class="fas fa-paperclip me-1"></i> Lihat Lampiran Lama
                            </a>
                        @else
                            <p class="text-muted mb-2"><em>Tidak ada lampiran</em></p>
                        @endif

                        <input 
                            type="file" 
                            id="attachment"
                            name="attachment" 
                            class="form-control form-control-sm @error('attachment') is-invalid @enderror"
                            accept=".jpg,.jpeg,.png,.pdf,.docx,.txt">

                        <small class="text-muted">File baru tidak boleh lebih dari 10 MB. Biarkan kosong jika tidak ingin mengganti lampiran.</small>

                        @error('attachment')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label>Kategori Asset</label>
                        <select name="kategori_id" id="kategori_id" class="form-control" required>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}" 
                                    {{ $ticket->asset && $ticket->asset->kategori_id == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Item Asset</label>
                        <select name="asset_id" id="asset_id" class="form-control @error('asset_id') is-invalid @enderror" required></select>
                        @error('asset_id')
                            <span class="invalid-feedback alert-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Prioritas, Lokasi & Status --}}
        <div class="card mb-3 shadow-sm border-0">
            <div class="card-header bg-light fw-bold">
                <i class="fas fa-map-marker-alt me-1"></i> Prioritas, Lokasi & Status
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label>Prioritas</label>
                        <select name="priority" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            @foreach(['Critical','High','Medium','Low'] as $priority)
                                <option value="{{ $priority }}" {{ $ticket->priority == $priority ? 'selected' : '' }}>{{ $priority }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Jumlah User Terdampak</label>
                        <input type="text" name="affected_users" class="form-control" value="{{ old('affected_users', $ticket->affected_users) }}">
                    </div>
                    <div class="col-md-4">
                        <label>Lokasi</label>
                        <input type="text" name="location" class="form-control" value="{{ old('location', $ticket->location) }}">
                    </div>
                    <div class="col-md-4">
                        <label>Status Ticket</label>
                        <select name="status" class="form-control" required>
                            @foreach(['Open','In Progress','Troubleshoot','Under Maintenance','Escalated','Resolved','Closed'] as $status)
                                <option value="{{ $status }}" {{ $ticket->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol --}}
        <div class="d-flex justify-content-between mt-3">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Simpan Perubahan
            </button>
            <a href="{{ route('backend.ticket.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </form>
</div>

{{-- JS Asset --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const kategoriSelect = document.getElementById('kategori_id');
    const assetSelect = document.getElementById('asset_id');
    const allAssets = @json($asset);
    const selectedAssetId = "{{ $ticket->asset_id }}";

    function renderAssets(kategoriId) {
        const filtered = allAssets.filter(a => a.kategori_id == kategoriId);
        let options = '<option value="">-- Pilih Item --</option>';
        filtered.forEach(a => {
            const roomText = a.room ? ` (${a.room})` : '';
            const isSelected = a.id == selectedAssetId ? 'selected' : '';
            options += `<option value="${a.id}" ${isSelected}>${a.item_name}${roomText}</option>`;
        });
        assetSelect.innerHTML = options;
    }

    const initialKategoriId = "{{ $ticket->asset ? $ticket->asset->kategori_id : $kategori->first()->id }}";
    kategoriSelect.value = initialKategoriId;
    renderAssets(initialKategoriId);
    kategoriSelect.addEventListener('change', () => renderAssets(kategoriSelect.value));
});
</script>
@endsection

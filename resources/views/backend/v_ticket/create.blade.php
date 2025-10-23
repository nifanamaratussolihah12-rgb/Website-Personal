@extends('backend.v_layouts.app')

@section('content')
<div class="container">
    <h4 class="d-flex align-items-center">
        <i class="fas fa-ticket-alt text-primary title-icon"></i>
        <span>Buat Ticket Baru</span>
    </h4>
    <form action="{{ route('backend.ticket.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Informasi Pelapor --}}
        <div class="card mb-3">
            <div class="card-header">Informasi Pelapor</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label>Nama Pelapor</label>
                        <input type="text" name="reporter_name" class="form-control" placeholder="Rika" required>
                    </div>
                    <div class="col-md-6">
                        <label>Departemen</label>
                        <input type="text" name="department" class="form-control" placeholder="IT">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="contact" class="form-label">Kontak (Telp/WA)</label>
                        <input 
                            type="text" 
                            id="contact"
                            name="contact" 
                            value="{{ old('contact') }}" 
                            class="form-control @error('contact') is-invalid @enderror"
                            placeholder="08xxxxxxxxxx">

                        @error('contact')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="xx@gmail.com">
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail Masalah --}}
        <div class="card mb-3">
            <div class="card-header">Detail Masalah</div>
            <div class="card-body">
                <div class="row">
                    {{-- Kategori --}}
                    <div class="col-md-6 mb-3">
                        <label>Kategori</label>
                        <select name="category" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="Hardware">Hardware</option>
                            <option value="Software">Software</option>
                            <option value="Network">Network</option>
                            <option value="Printer">Printer</option>
                            <option value="Account/Email">Account/Email</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    {{-- Subjek Masalah --}}
                    <div class="col-md-6 mb-3">
                        <label>Subjek Masalah</label>
                        <input type="text" name="subject" class="form-control" placeholder="note:">
                    </div>

                    {{-- Deskripsi & Lampiran di satu baris --}}
                    <div class="col-md-6 mb-3">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="note:" style="height:100px"></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="attachment" class="form-label">Lampiran</label>
                        <input 
                            type="file" 
                            id="attachment"
                            name="attachment" 
                            class="form-control @error('attachment') is-invalid @enderror"
                            accept=".jpg,.jpeg,.png,.pdf,.docx,.txt">
                        
                        <small class="text-muted">File tidak boleh lebih dari 10 MB.</small>

                        @error('attachment')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Kategori Asset --}}
                    <div class="col-md-6 mb-3">
                        <label>Kategori Asset</label>
                        <select name="kategori_id" id="kategori_id" class="form-control" required>
                            @foreach($kategori as $index => $k)
                                <option value="{{ $k->id }}" {{ $index == 0 ? 'selected' : '' }}>
                                    {{ $k->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Asset --}}
                    <div class="col-md-6 mb-3">
                        <label>Asset</label>
                        <select name="asset_id" id="asset_id" class="form-control" required>
                            {{-- JS akan filter dari $asset --}}
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- Script --}}
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kategoriSelect = document.getElementById('kategori_id');
            const assetSelect = document.getElementById('asset_id');
            const allAssets = @json($asset);

            function renderAssets(kategoriId) {
                const filtered = allAssets.filter(a => a.kategori_id == kategoriId);
                let options = '<option value="">-- Pilih Item --</option>';
                filtered.forEach(a => {
                    // pilih label tambahan: room dulu, kalau tidak ada pakai user
                    let labelTambahan = a.room || a.user; 
                    let labelText = labelTambahan ? ` (${labelTambahan})` : '';
                    options += `<option value="${a.id}">${a.item_name}${labelText}</option>`;
                });
                assetSelect.innerHTML = options;
            }

            renderAssets(kategoriSelect.value);
            kategoriSelect.addEventListener('change', function() {
                renderAssets(this.value);
            });
        });
        </script>
  

        {{-- Prioritas, Lokasi & Status --}}
        <div class="card mb-3">
            <div class="card-header">Prioritas, Lokasi & Status</div>
            <div class="card-body">
                <div class="row g-3">
                    {{-- Prioritas --}}
                    <div class="col-md-3">
                        <label>Prioritas</label>
                        <select name="priority" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="Critical">Critical</option>
                            <option value="High">High</option>
                            <option value="Medium">Medium</option>
                            <option value="Low">Low</option>
                        </select>
                    </div>

                    {{-- Jumlah User Terdampak --}}
                    <div class="col-md-3">
                        <label>Jumlah User Terdampak</label>
                        <input type="text" name="affected_users" class="form-control" placeholder="2 orang">
                    </div>

                    {{-- Lokasi --}}
                    <div class="col-md-3">
                        <label>Lokasi</label>
                        <input type="text" name="location" class="form-control" placeholder="Palu">
                    </div>

                    {{-- Status Ticket --}}
                    <div class="col-md-3">
                        <label>Status Ticket</label>
                        <select name="status" class="form-control" required>
                            <option value="Open">Open</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Troubleshoot">Troubleshoot</option>
                            <option value="Under Maintenance">Under Maintenance</option>
                            <option value="Escalated">Escalated</option>
                            <option value="Resolved">Resolved</option>
                            <option value="Closed">Closed</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Buat Ticket</button>
        <a href="{{ route('backend.ticket.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection


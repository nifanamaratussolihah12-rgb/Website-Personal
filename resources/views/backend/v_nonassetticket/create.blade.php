@extends('backend.v_layouts.app')

@section('content')
<div class="container">
    <h4 class="d-flex align-items-center">
        <i class="fas fa-ticket-alt text-primary title-icon"></i>
        <span>Buat Service Items Baru</span>
    </h4>
    <form action="{{ route('backend.nonassetticket.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Informasi Pelapor --}}
        <div class="card mb-3">
            <div class="card-header">Informasi Pelapor</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label>Nama Pelapor</label>
                        <input type="text" name="reporter_name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Departemen</label>
                        <input type="text" name="department" class="form-control">
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
                        <input type="email" name="email" class="form-control">
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail Masalah --}}
        <div class="card mb-3">
            <div class="card-header">Detail Masalah</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
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

                    {{-- Input Manual Asset Name --}}
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
                                // pakai room dulu, kalau kosong pakai user
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

                    <div class="col-md-6">
                        <label>Item Name</label>
                        <input type="text" name="asset_name" class="form-control" placeholder="Input nama asset secara manual">
                    </div>

                    <div class="col-md-6">
                        <label>Subjek Masalah</label>
                        <input type="text" name="subject" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label>Lampiran</label>
                        <input type="file" name="attachment" class="form-control" accept=".jpg,.jpeg,.png,.pdf,.docx,.txt">
                    </div>

                    <div class="col-md-6">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" rows="4" style="height:100px" required></textarea>
                    </div>

                </div>
            </div>
        </div>

        {{-- Prioritas, Lokasi & Status --}}
        <div class="card mb-3">
            <div class="card-header">Prioritas, Lokasi & Status</div>
            <div class="card-body">
                <div class="row g-3">
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

                    <div class="col-md-3">
                        <label>Jumlah User Terdampak</label>
                        <input type="text" name="affected_users" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label>Lokasi</label>
                        <input type="text" name="location" class="form-control">
                    </div>

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
        <a href="{{ route('backend.nonassetticket.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

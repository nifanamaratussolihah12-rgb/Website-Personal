@extends('backend.v_layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('backend.nonassetticket.update', $nonAssetTicket->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <h4 class="d-flex align-items-center">📝 Edit Ticket #{{ $nonAssetTicket->ticket_number }}</h4>
        <hr>
        {{-- Informasi Pelapor --}}
        <div class="card mb-3">
            <div class="card-header">Informasi Pelapor</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label>Nama Pelapor</label>
                        <input type="text" name="reporter_name" class="form-control" 
                               value="{{ old('reporter_name', $nonAssetTicket->reporter_name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label>Departemen</label>
                        <input type="text" name="department" class="form-control"
                               value="{{ old('department', $nonAssetTicket->department) }}">
                    </div>
                    <div class="col-md-6">
                        <label>Kontak (Telp/WA)</label>
                        <input type="text" name="contact" class="form-control"
                               value="{{ old('contact', $nonAssetTicket->contact) }}">
                    </div>
                    <div class="col-md-6">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email', $nonAssetTicket->email) }}">
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
                            @foreach(['Hardware','Software','Network','Printer','Account/Email','Other'] as $cat)
                                <option value="{{ $cat }}" {{ old('category', $nonAssetTicket->category) == $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Kategori Asset</label>
                        <select name="kategori_id" id="kategori_id" class="form-control" required>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}" 
                                    {{ $nonAssetTicket->asset && $nonAssetTicket->asset->kategori_id == $k->id ? 'selected' : '' }}>
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

                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const kategoriSelect = document.getElementById('kategori_id');
                        const assetSelect = document.getElementById('asset_id');
                        const allAssets = @json($asset);
                        const selectedAsset = "{{ old('asset_id', $nonAssetTicket->asset_id) }}";

                        function renderAssets(kategoriId) {
                            const filtered = allAssets.filter(a => a.kategori_id == kategoriId);
                            let options = '<option value="">-- Pilih Item --</option>';
                            filtered.forEach(a => {
                                let roomText = a.room ? ` (${a.room})` : '';
                                options += `<option value="${a.id}" ${a.id == selectedAsset ? 'selected' : ''}>${a.item_name}${roomText}</option>`;
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
                        <input type="text" name="asset_name" class="form-control" 
                               value="{{ old('asset_name', $nonAssetTicket->asset_name) }}"
                               placeholder="Input nama asset secara manual">
                    </div>

                    <div class="col-md-6">
                        <label>Subjek Masalah</label>
                        <input type="text" name="subject" class="form-control" 
                               value="{{ old('subject', $nonAssetTicket->subject) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label>Lampiran</label>
                        <input type="file" name="attachment" class="form-control" accept=".jpg,.jpeg,.png,.pdf,.docx,.txt">
                        @if($nonAssetTicket->attachment)
                            <small class="text-muted">File saat ini: 
                                <a href="{{ asset('storage/'.$nonAssetTicket->attachment) }}" target="_blank">Lihat Lampiran</a>
                            </small>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" rows="4" style="height:100px" required>{{ old('description', $nonAssetTicket->description) }}</textarea>
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
                            @foreach(['Critical','High','Medium','Low'] as $prio)
                                <option value="{{ $prio }}" {{ old('priority', $nonAssetTicket->priority) == $prio ? 'selected' : '' }}>
                                    {{ $prio }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Jumlah User Terdampak</label>
                        <input type="text" name="affected_users" class="form-control"
                               value="{{ old('affected_users', $nonAssetTicket->affected_users) }}">
                    </div>

                    <div class="col-md-3">
                        <label>Lokasi</label>
                        <input type="text" name="location" class="form-control"
                               value="{{ old('location', $nonAssetTicket->location) }}">
                    </div>

                    <div class="col-md-3">
                        <label>Status Ticket</label>
                        <select name="status" class="form-control" required>
                            @foreach(['Open','In Progress','Troubleshoot','Under Maintenance','Escalated','Resolved','Closed'] as $st)
                                <option value="{{ $st }}" {{ old('status', $nonAssetTicket->status) == $st ? 'selected' : '' }}>
                                    {{ $st }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Ticket</button>
        <a href="{{ route('backend.nonassetticket.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

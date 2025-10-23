@extends('backend.v_layouts.app')

@section('content')
<div class="card">
  <div class="card-body">
    <div class="card-body p-4">
       <h4 class="mb-4">
        <i class="mdi mdi-wrench text-primary me-2"></i>
        Edit Maintenance Asset
      </h4>
      <hr>
      <form action="{{ route('backend.asset-maintenance.update', $maintenance->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3">
          {{-- Item Asset --}}
          <div class="col-md-6">
            <label class="fw-semibold">Item Asset</label>
            <select name="asset_id" class="form-control @error('asset_id') is-invalid @enderror" required>
              <option value="">-- Pilih Item --</option>
              @foreach($asset->sortBy('item_name') as $a)
                <option value="{{ $a->id }}" {{ old('asset_id', $maintenance->asset_id) == $a->id ? 'selected' : '' }}>
                  {{ Str::limit($a->item_name, 30) }}
                </option>
              @endforeach
            </select>
            @error('asset_id')
              <span class="invalid-feedback alert-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Tanggal Isu --}}
          <div class="col-md-6">
            <label class="fw-semibold">Tanggal Isu</label>
            <input type="date" name="issue_date"
              value="{{ old('issue_date', $maintenance->issue_date ? $maintenance->issue_date->format('Y-m-d') : '') }}"
              class="form-control @error('issue_date') is-invalid @enderror">
            @error('issue_date')
              <span class="invalid-feedback alert-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Jenis Maintenance --}}
          <div class="col-md-6">
            <label class="fw-semibold">Jenis Maintenance</label>
            <select name="maintenance_type" class="form-control @error('maintenance_type') is-invalid @enderror">
              <option value="">-- Pilih Jenis --</option>
              <option value="preventive" {{ old('maintenance_type', $maintenance->maintenance_type) == 'preventive' ? 'selected' : '' }}>Preventive</option>
              <option value="corrective" {{ old('maintenance_type', $maintenance->maintenance_type) == 'corrective' ? 'selected' : '' }}>Corrective</option>
              <option value="replace" {{ old('maintenance_type', $maintenance->maintenance_type) == 'replace' ? 'selected' : '' }}>Replace</option>
            </select>
            @error('maintenance_type')
              <span class="invalid-feedback alert-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Penjadwalan --}}
          <div class="col-md-6">
            <label class="fw-semibold">Tanggal Penjadwalan</label>
            <input type="date" name="schedule_date"
              value="{{ old('schedule_date', $maintenance->schedule_date ? $maintenance->schedule_date->format('Y-m-d') : '') }}"
              class="form-control @error('schedule_date') is-invalid @enderror">
            @error('schedule_date')
              <span class="invalid-feedback alert-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Biaya --}}
          <div class="col-md-6">
            <label class="fw-semibold">Biaya</label>
            <input type="number" name="cost" value="{{ old('cost', $maintenance->cost) }}"
              class="form-control @error('cost') is-invalid @enderror" placeholder="0">
            @error('cost')
              <span class="invalid-feedback alert-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Priority --}}
          <div class="col-md-6">
            <label class="fw-semibold">Prioritas</label>
            <select name="priority" class="form-control @error('priority') is-invalid @enderror">
              <option value="">-- Pilih Prioritas --</option>
              <option value="Top Urgent" {{ old('priority', $maintenance->priority) == 'Top Urgent' ? 'selected' : '' }}>Top Urgent</option>
              <option value="Urgent" {{ old('priority', $maintenance->priority) == 'Urgent' ? 'selected' : '' }}>Urgent</option>
              <option value="Medium" {{ old('priority', $maintenance->priority) == 'Medium' ? 'selected' : '' }}>Medium</option>
              <option value="Low" {{ old('priority', $maintenance->priority) == 'Low' ? 'selected' : '' }}>Low</option>
            </select>
            @error('priority')
              <span class="invalid-feedback alert-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Status --}}
          <div class="col-md-6">
            <label class="fw-semibold">Status</label>
            <select name="status" class="form-control @error('status') is-invalid @enderror">
              <option value="">-- Pilih Status --</option>
              <option value="pending" {{ old('status', $maintenance->status) == 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="done" {{ old('status', $maintenance->status) == 'done' ? 'selected' : '' }}>Done</option>
              <option value="cancelled" {{ old('status', $maintenance->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            @error('status')
              <span class="invalid-feedback alert-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Ditangani Oleh --}}
          <div class="col-md-6">
            <label class="fw-semibold">Ditangani Oleh</label>
            <select name="handled_by" class="form-control @error('handled_by') is-invalid @enderror">
              <option value="">-- Pilih User --</option>
              @foreach($user->sortBy('nama') as $a)
                <option value="{{ $a->id }}" {{ old('handled_by', $maintenance->handled_by) == $a->id ? 'selected' : '' }}>
                  {{ Str::limit($a->nama, 25) }}
                </option>
              @endforeach
            </select>
            @error('handled_by')
              <span class="invalid-feedback alert-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Catatan --}}
          <div class="col-md-12">
            <label class="fw-semibold">Catatan</label>
            <textarea name="notes" rows="3" class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $maintenance->notes) }}</textarea>
            @error('notes')
              <span class="invalid-feedback alert-danger">{{ $message }}</span>
            @enderror
          </div>
        </div>

        {{-- Tombol --}}
        <div class="text-end mt-4">
          <a href="{{ route('backend.asset-maintenance.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
          </a>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i> Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

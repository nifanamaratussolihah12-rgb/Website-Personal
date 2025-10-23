@extends('backend.v_layouts.app')
@section('content')
<div class="card">
  <div class="card-body">
    <form action="{{ route('backend.asset-maintenance.store') }}" method="POST">
      @csrf
      <div class="row">

        {{-- RIGHT COLUMN (form inputs) --}}
        <div class="col-md-12">

          {{-- Item Asset --}}
          <div class="form-group mb-2">
              <label>Item Asset</label>
              <select name="asset_id" id="asset_id"
                  class="form-control @error('asset_id') is-invalid @enderror"
                  required>
                  <option value="">-- Pilih Item --</option>
                  @foreach($asset->sortBy('item_name') as $a)
                      @php
                          // pilih label tambahan: room dulu, kalau gak ada baru user
                          $labelTambahan = $a->room ?: $a->user;
                      @endphp
                      <option value="{{ $a->id }}">
                          {{ Str::limit($a->item_name, 25) }}
                          {{ $labelTambahan ? ' (' . $labelTambahan . ')' : '' }}
                      </option>
                  @endforeach
              </select>
              @error('asset_id')
                  <span class="invalid-feedback alert-danger">{{ $message }}</span>
              @enderror
          </div>

          {{-- Tanggal Isu --}}
          <div class="form-group mb-2">
            <label>Tanggal Isu</label>
            <input type="date" name="issue_date" value="{{ old('issue_date') }}"
              class="form-control @error('issue_date') is-invalid @enderror">
            @error('issue_date')
              <span class="invalid-feedback alert-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Jenis Maintenance --}}
          <div class="form-group mb-2">
            <label>Jenis Maintenance</label>
            <select name="maintenance_type" class="form-control @error('maintenance_type') is-invalid @enderror">
              <option value="">-- Pilih Jenis --</option>
              <option value="preventive" {{ old('maintenance_type')=='preventive'?'selected':'' }}>Preventive</option>
              <option value="corrective" {{ old('maintenance_type')=='corrective'?'selected':'' }}>Corrective</option>
              <option value="replace" {{ old('maintenance_type')=='replace'?'selected':'' }}>Replace</option>
            </select>
            @error('maintenance_type')
              <span class="invalid-feedback alert-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Penjadwalan --}}
          <div class="form-group mb-2">
            <label>Penjadwalan</label>
            <input type="date" name="schedule_date" value="{{ old('schedule_date') }}"
              class="form-control @error('schedule_date') is-invalid @enderror">
            @error('schedule_date')
              <span class="invalid-feedback alert-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Biaya --}}
          <div class="form-group mb-2">
              <label>Biaya</label>
              <input type="text" id="cost" value="{{ old('cost') }}"
                  class="form-control @error('cost') is-invalid @enderror" placeholder="0">
              <input type="hidden" name="cost" id="cost_hidden" value="{{ old('cost') }}">
              @error('cost')
                  <span class="invalid-feedback alert-danger">{{ $message }}</span>
              @enderror
          </div>

          <script>
          document.addEventListener('DOMContentLoaded', function() {
              const costInput = document.getElementById('cost');
              const costHidden = document.getElementById('cost_hidden');

              function formatRupiah(value) {
                  let number_string = value.replace(/[^,\d]/g, '').toString();
                  let split = number_string.split(',');
                  let sisa = split[0].length % 3;
                  let rupiah = split[0].substr(0, sisa);
                  let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                  if (ribuan) {
                      let separator = sisa ? '.' : '';
                      rupiah += separator + ribuan.join('.');
                  }

                  rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                  return rupiah ? 'Rp. ' + rupiah : '';
              }

              costInput.addEventListener('input', function(e) {
                  let rawValue = this.value.replace(/[^,\d]/g, '');
                  costHidden.value = rawValue;
                  this.value = formatRupiah(this.value);
              });

              // format awal kalau ada old value
              if (costHidden.value) {
                  costInput.value = formatRupiah(costHidden.value);
              }
          });
          </script>

          {{-- Priority --}}
          <div class="form-group mb-2">
              <label>Priority</label>
              @php
                  $priorities = ['Top Urgent', 'Urgent', 'Medium', 'Low'];
              @endphp

              <select name="priority" class="form-control @error('priority') is-invalid @enderror">
                  <option value="">-- Pilih Priority --</option>
                  @foreach($priorities as $p)
                      <option value="{{ $p }}" {{ old('priority')==$p ? 'selected' : '' }}>{{ $p }}</option>
                  @endforeach
              </select>

              @error('priority')
                  <span class="invalid-feedback alert-danger">{{ $message }}</span>
              @enderror
          </div>

          {{-- Status --}}
          <div class="form-group mb-2">
            <label>Status</label>
            <select name="status" class="form-control @error('status') is-invalid @enderror">
              <option value="">-- Pilih Status --</option>
              <option value="pending" {{ old('status')=='pending'?'selected':'' }}>Pending</option>
              <option value="done" {{ old('status')=='done'?'selected':'' }}>Done</option>
              <option value="cancelled" {{ old('status')=='cancelled'?'selected':'' }}>Cancelled</option>
            </select>
            @error('status')
              <span class="invalid-feedback alert-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Ditangani Oleh --}}
          <div class="form-group mb-2">
            <label>Ditangani Oleh</label>
            <select name="handled_by" class="form-control @error('handled_by') is-invalid @enderror">
              <option value="">-- Pilih User --</option>
                @foreach($user->sortBy('nama') as $a)
                  <option value="{{ $a->id }}">
                    {{ Str::limit($a->nama, 25) }}
                  </option>
                @endforeach
              </select>
              @error('user_id')
              <span class="invalid-feedback alert-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Catatan --}}
          <div class="form-group mb-2">
            <label>Catatan</label>
            <textarea name="notes" rows="3" class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
            @error('notes')
              <span class="invalid-feedback alert-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Submit --}}
          <div class="text-end mt-3">
            <button type="submit" class="btn btn-success"><i class="mdi mdi-content-save me-1"></i> Simpan</button>
            <a href="{{ route('backend.asset-maintenance.index') }}" class="btn btn-secondary">Kembali</a>
          </div>

        </div>
      </div>
    </form>
  </div>
</div>
@endsection

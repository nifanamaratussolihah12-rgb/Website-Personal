@extends('backend.v_layouts.app')

@section('content')
<div class="card shadow-sm border-0">
  <div class="card-body">
    <h4 class="card-title mb-3"><i class="fas fa-boxes me-2 text-primary"></i> Daftar Type Asset</h4>
    <hr>

    <div class="mb-3">
      <a href="{{ route('backend.typeasset.create') }}" class="btn btn-success btn-sm">
        <i class="fas fa-plus me-1"></i> Add 
      </a>
    </div>

    <div class="table-responsive">
      <table id="typeasset_table" class="table table-hover table-bordered align-middle">
        <thead class="table-custom" style="background-color:#d4e0d7ff; color:#000; font-weight:normal; font-size:12px;">
          <tr>
            <th class="text-center" style="width:50px;">No</th>
            <th class="text-center">Asset Type Name</th>
            <th class="text-center" style="width:220px;">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($index as $row)
          <tr>
            <td class="text-center px-3 py-2" style="font-size:13px;">{{ $loop->iteration }}</td>
            <td class="px-3 py-2 fw-semibold" style="font-size:13px;">{{ ucwords(str_replace('_', ' ', $row->nama_type)) }}</td>
            <td class="d-flex justify-content-center px-3 py-2" style="gap:5px; font-size:13px;">
              <a href="{{ route('backend.typeasset.detail', $row->id) }}" 
                class="btn btn-outline-secondary btn-sm d-flex align-items-center justify-content-center" 
                style="width:36px; height:30px; font-size:13px;" 
                data-bs-toggle="tooltip" title="Detail">
                  <i class="fas fa-eye" style="font-size:13px;"></i>
              </a>

              @if(auth()->check() && in_array(auth()->user()->role, [0,1,2]))
              <a href="{{ route('backend.typeasset.edit', $row->id) }}" 
                class="btn btn-outline-primary btn-sm d-flex align-items-center justify-content-center" 
                style="width:36px; height:30px; font-size:13px;" 
                data-bs-toggle="tooltip" title="Ubah">
                  <i class="far fa-edit" style="font-size:13px;"></i>
              </a>

              <form method="POST" action="{{ route('backend.typeasset.destroy', $row->id) }}" class="d-inline-flex align-items-center m-0 p-0">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-outline-danger btn-sm d-flex align-items-center justify-content-center show_confirm" 
                          style="width:36px; height:30px; font-size:13px;" 
                          data-konf-delete="{{ $row->nama_type }}" 
                          data-bs-toggle="tooltip" title="Hapus">
                      <i class="fas fa-trash" style="font-size:13px;"></i>
                  </button>
              </form>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

<style>
  th.no-sort::after, th.no-sort::before { display: none !important; }

  .table td, .table th { padding: 0.35rem 0.5rem; font-size: 15px; }
  .btn-sm { padding: 0.25rem 0.5rem; font-size: 12px; }
  .card-body { padding: 0.75rem 1rem; }
</style>

@push('scripts')
<script>
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
  })

  $(document).ready(function() {
      $('#typeasset_table').DataTable({
          ordering: true,
          searching: false,
          paging: false,
          info: false,
          columnDefs: [
              { orderable: true, targets: 0 },
              { orderable: false, targets: [1, 2] }
          ]
      });
  });
</script>
@endpush

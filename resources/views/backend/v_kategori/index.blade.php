@extends('backend.v_layouts.app')

@section('content')
<div class="card shadow-sm border-0">
  <div class="card-body">
    <h4 class="card-title mb-3"><i class="fas fa-tags me-2 text-primary"></i> List of Categories</h4>
    <hr>

    <div class="mb-3">
      <a href="{{ route('backend.kategori.create') }}" class="btn btn-success btn-sm">
        <i class="fas fa-plus me-1"></i> Add Category
      </a>
    </div>

    <div class="table-responsive">
      <table id="kategori_table" class="table table-hover table-striped table-bordered align-middle">
        <thead class="table-custom" style="background-color:#88c6edff; color:#000; font-weight:normal; font-size:14px;">
          <tr>
            <th class="text-center" style="width:50px;">No</th>
            <th class="text-center">Category Name</th>
            <th class="text-center" style="width:220px;">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($index as $row)
          <tr>
            <td class="text-center px-2 py-1" style="font-size:13px;">{{ $loop->iteration }}</td>
            <td class="px-2 py-1 fw-semibold" style="font-size:13px;">{{ ucwords(str_replace('_', ' ', $row->nama_kategori)) }}</td>
            <td class="d-flex justify-content-center px-2 py-1" style="gap:5px; font-size:11px;">
              <a href="{{ route('backend.kategori.detail', $row->id) }}" 
                class="btn btn-outline-secondary btn-sm d-flex align-items-center justify-content-center" 
                style="width:36px; height:30px; font-size:11px;" 
                data-bs-toggle="tooltip" title="Detail">
                  <i class="fas fa-eye" style="font-size:11px;"></i>
              </a>

              @if(auth()->check() && in_array(auth()->user()->role, [0,1,2]))
              <a href="{{ route('backend.kategori.edit', $row->id) }}" 
                class="btn btn-outline-primary btn-sm d-flex align-items-center justify-content-center" 
                style="width:36px; height:30px; font-size:11px;" 
                data-bs-toggle="tooltip" title="Ubah">
                  <i class="far fa-edit" style="font-size:11px;"></i>
              </a>

              <form method="POST" action="{{ route('backend.kategori.destroy', $row->id) }}" class="d-inline-flex align-items-center m-0 p-0">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-outline-danger btn-sm d-flex align-items-center justify-content-center show_confirm" 
                          style="width:36px; height:30px; font-size:11px;" 
                          data-konf-delete="{{ $row->nama_kategori }}" 
                          data-bs-toggle="tooltip" title="Hapus">
                      <i class="fas fa-trash" style="font-size:11px;"></i>
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
  /* Hilangkan tanda sort untuk kolom selain No */
  th.no-sort::after, th.no-sort::before { display: none !important; }

  /* Tabel compact dan rapi */
  .table td, .table th { padding: 0.35rem 0.5rem; font-size: 15px; }
  .btn-sm { padding: 0.25rem 0.5rem; font-size: 12px; }
  .card-body { padding: 0.75rem 1rem; }
</style>

@push('scripts')
<script>
  // Inisialisasi tooltip Bootstrap
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
  })

  // DataTables hanya untuk urut No, kolom lain tetap non-sort
  $(document).ready(function() {
      $('#kategori_table').DataTable({
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

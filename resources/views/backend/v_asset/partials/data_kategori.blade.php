<div class="card shadow-sm border-0">
  <div class="card-body">
    <h4 class="card-title mb-3"><i class="fas fa-tags me-2 text-primary"></i> Daftar Kategori Asset</h4>
    <hr>

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
      <a href="{{ route('backend.kategori.create') }}" class="btn btn-success btn-sm mb-2 mb-md-0">
        <i class="fas fa-plus me-1"></i> Add 
      </a>
      
      <!-- Placeholder search (DataTables akan otomatis taruh di sini) -->
      <div id="custom-search-kategori"></div>
    </div>

    <div class="table-responsive">
      <table id="kategori_table" class="table table-hover table-bordered align-middle">
        <thead class="table-custom" style="background-color:#dcdff5ff; color:#000; font-weight:normal; font-size:14px;">
          <tr>
            <th class="text-center" style="width:10px;">No</th>
            <th class="text-center" style="width:240px;">Category Name</th>
            <th class="text-center" style="width:20px;">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($kategoriList as $row)
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

<style>
  /* Hilangkan tanda sort untuk kolom selain No */
  th.no-sort::after, th.no-sort::before { display: none !important; }

  /* Tabel compact dan rapi */
  .table td, .table th { padding: 0.35rem 0.5rem; font-size: 15px; }
  .btn-sm { padding: 0.25rem 0.5rem; font-size: 12px; }
  .card-body { padding: 0.75rem 1rem; }


  
  /* 🌿 Biar label dan input sejajar */
  #custom-search-kategori label {
    display: flex;
    align-items: center;
    gap: 6px;
    margin: 0;
  }

  #custom-search-kategori input[type="search"] {
    width: 220px;
    height: 30px;
    font-size: 13px;
    padding: 4px 8px;
    border: 1px solid #ccc;
    border-radius: 6px;
    background-color: #fff;
  }

  #custom-search-kategori input[type="search"]:focus {
    outline: none;
    border-color: #6cb2eb;
    box-shadow: 0 0 4px rgba(108,178,235,0.5);
  }

  /* Optional — kecilin label */
  #custom-search-kategori label {
    font-size: 14px;
    font-weight: 500;
    color: #333;
  }

</style>

@push('scripts')
<script>
  // Inisialisasi tooltip Bootstrap
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // ✅ DataTables dengan sort di semua kolom (kecuali Action) + search aktif
  $(document).ready(function() {
      var table = $('#kategori_table').DataTable({
          ordering: true,
          searching: true,   // 🔍 aktifkan fitur pencarian
          paging: false,
          info: false,
          columnDefs: [
              { orderable: false, targets: 2 } // ❌ kolom "Action" (indeks ke-2) non-sort
          ],
          language: {
              search: "Search:",
              zeroRecords: "Tidak ada kategori ditemukan"
          },
          dom: '<"top"f>rt',
          initComplete: function() {
              // 🔧 Pindahkan elemen search ke container custom
              $('#kategori_table_filter').appendTo('#custom-search-kategori');
          }
      });
  });
</script>

@endpush

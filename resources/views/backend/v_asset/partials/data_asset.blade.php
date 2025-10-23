<div class="card shadow-sm border-0">
  <div class="card-body">
    <h4 class="card-title mb-3">📦 Daftar Asset</h4>
    <hr>

    <div class="mb-3 d-flex justify-content-between">
        <!-- Tombol Tambah Asset -->
        <div class="btn-group">
            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fas fa-plus me-1"></i> Add 
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('backend.asset.create') }}">Asset Fisik</a></li>
                <li><a class="dropdown-item" href="{{ route('backend.asset.create_service') }}">Service / Non-Fisik</a></li>
            </ul>
        </div>

        <!-- Import & Export Excel (Admin only) -->
        <div class="d-flex" style="gap: 8px;">
            @if(auth()->check() && in_array(auth()->user()->role, [0,1,2]))
            <a href="{{ route('backend.asset.import.form') }}" class="btn btn-warning btn-sm d-flex align-items-center">
                <i class="mdi mdi-file-import me-1"></i> Import Data Asset
            </a>
            @endif
            <a href="{{ route('backend.asset.export') }}" class="btn btn-success btn-sm d-flex align-items-center">
                <i class="mdi mdi-file-export me-1"></i> Export Data Asset
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table id="assetTable" class="table table-hover table-bordered align-middle">
            <thead class="table-custom" style="background-color:#dcdff5ff; color:#000; font-weight:normal; font-size:11px;">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Type Asset</th>
                    <th class="text-center">Code</th>
                    <th class="text-center">Asset Number</th>
                    <th class="text-center">User</th>
                    <th class="text-center">Item Name</th>
                    <th class="text-center">Qty</th>
                    <th class="text-center">Room</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody style="font-size:10px;">
                @foreach ($index as $row)
                <tr>
                    <td class="text-center px-3 py-2">{{ $loop->iteration }}</td>
                    <td class="px-3 py-2">{{ $row->asset_type ?? '-' }}</td>
                    <td class="px-3 py-2">{{ $row->code ?? '-' }}</td>
                    <td class="px-3 py-2">{{ $row->asset_number ?? '-' }}</td>
                    <td class="px-3 py-2">{{ $row->user ?? '-' }}</td>
                    <td class="px-3 py-2">{{ $row->item_name ?? '-' }}</td>
                    <td class="px-3 py-2">{{ $row->qty ?? 0 }}</td>
                    <td class="px-3 py-2">{{ $row->room ?? '-' }}</td>
                    <td class="d-flex justify-content-end px-3 py-2" style="gap:5px;">
                        <!-- Detail -->
                        @if($row->asset_kind == 'service')
                            <!-- Detail Service -->
                            <a href="{{ route('backend.asset.show_service', $row->id) }}" 
                            class="btn btn-info btn-sm" title="Lihat Detail Service">
                                <i class="fas fa-eye"></i>
                            </a>
                        @else
                            <!-- Detail Fisik -->
                            <a href="{{ route('backend.asset.show', $row->id) }}" 
                            class="btn btn-info btn-sm" title="Lihat Detail Asset">
                                <i class="fas fa-eye"></i>
                            </a>
                        @endif

                        @if(auth()->check() && in_array(auth()->user()->role, [0,1,2]))
                        <!-- Edit -->
                        @if($row->asset_kind == 'service')
                            <!-- Edit Service -->
                            <a href="{{ route('backend.asset.edit_service', $row->id) }}" class="btn btn-cyan btn-sm" title="Ubah Data Service">
                                <i class="far fa-edit"></i>
                            </a>
                        @else
                            <!-- Edit Fisik -->
                            <a href="{{ route('backend.asset.edit', $row->id) }}" class="btn btn-cyan btn-sm" title="Ubah Data">
                                <i class="far fa-edit"></i>
                            </a>
                        @endif

                        <!-- Hapus -->
                        <form method="POST" action="{{ route('backend.asset.destroy', $row->id) }}" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-danger btn-sm show_confirm" 
                                    data-konf-delete="{{ $row->item_name ?? $row->id }}" 
                                    title="Hapus Data">
                                <i class="fas fa-trash"></i>
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
  /* Khusus untuk teks di tabel Asset */
  #assetTable th, 
  #assetTable td {
      font-size: 13px !important;  /* ukuran mirip halaman kategori */
      font-family: "Poppins", sans-serif; /* opsional, kalau mau seragam */
      font-weight: 400; /* biar nggak terlalu tebal */
      color: #222; /* warna teks netral */
  }

  /* Header tabel (judul kolom) */
  #assetTable thead th {
      font-size: 14px !important;
      font-weight: 600;
  }
</style>

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#assetTable').DataTable({
        ordering: true,
        searching: true,
        pageLength: 10,
        order: [[0, "asc"]],
        columnDefs: [
            { orderable: false, targets: -1 } // hanya kolom terakhir (Action) yang tidak bisa diurutkan
        ],
        language: {
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            zeroRecords: "Tidak ada data ditemukan",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data tersedia",
            infoFiltered: "(disaring dari _MAX_ total data)",
            search: "Search:",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "›",
                previous: "‹"
            }
        }
    });
});
</script>
@endpush

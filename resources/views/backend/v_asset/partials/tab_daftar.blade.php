<div class="card shadow-sm border-0">
  <div class="card-body">
    <h4 class="card-title mb-3">📦 {{ $judul }}</h4>
    <hr>

    <!-- Tombol Tambah Asset -->
    <div class="mb-3">
        <a href="{{ route('backend.asset.create') }}" class="btn btn-primary btn-sm" style="padding: 0.35rem 0.6rem;">
            <i class="fas fa-plus me-1"></i> Add 
        </a>
    </div>

    <div class="table-responsive">
        <table id="assetTable" class="table table-hover table-bordered align-middle">
            <thead class="table-custom" style="background-color:#dcdff5ff; color:#000; font-weight:normal; font-size:14px;">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Type Asset</th>
                    <th class="text-center">Code</th>
                    <th class="text-center">Asset Number</th>
                    <th class="text-center">Item Name</th>
                    <th class="text-center">Qty</th>
                    <th class="text-center">Room</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody style="font-size:13px;">
                @foreach ($asset as $row)
                <tr>
                    <td class="text-center px-3 py-2">{{ $loop->iteration }}</td>
                    <td class="px-3 py-2">{{ $row->asset_type ?? '-' }}</td>
                    <td class="px-3 py-2">{{ $row->code ?? '-' }}</td>
                    <td class="px-3 py-2">{{ $row->asset_number ?? '-' }}</td>
                    <td class="px-3 py-2">{{ $row->item_name ?? '-' }}</td>
                    <td class="px-3 py-2">{{ $row->qty ?? 0 }}</td>
                    <td class="px-3 py-2">{{ $row->room ?? '-' }}</td>
                    <td class="d-flex justify-content-end px-3 py-2" style="gap:5px;">
                        <!-- Detail (semua user) -->
                        <a href="{{ route('backend.asset.show', $row->id) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </a>

                        @if(auth()->check() && in_array(auth()->user()->role, [0,1,2]))
                        <!-- Edit -->
                        <a href="{{ route('backend.asset.edit', $row->id) }}" class="btn btn-cyan btn-sm" title="Ubah Data">
                            <i class="far fa-edit"></i>
                        </a>

                        <!-- Hapus -->
                        <form method="POST" action="{{ route('backend.asset.destroy', $row->id) }}" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm show_confirm" 
                                    data-konf-delete="{{ $row->item_name }}" title="Hapus Data">
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

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"/>
@endpush

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

@extends('backend.v_layouts.app')

@section('content')
<div class="card shadow-sm border-0">
  <div class="card-body">
    <h4 class="card-title mb-3">🛠️ Asset Maintenance</h4>
    <hr>

    <div class="mb-3">
    <a href="{{ route('backend.asset-maintenance.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add
    </a>
    </div>
    

    <div class="table-responsive">
        <table id="maintenanceTable" class="table table-hover table-bordered align-middle">
            <thead class="table-custom" style="background-color:#dcdff5ff; color:#000; font-weight:normal; font-size:14px;">
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Asset</th>
                <th class="text-center">Tanggal Isu</th>
                <th class="text-center">Jenis Maintenance</th>
                <th class="text-center">Priority</th>
                <th class="text-center">Biaya</th>
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
            </tr>
            </thead>
            <tbody style="font-size:13px;">
            @foreach ($maintenances as $row)
            <tr>
                <td class="text-center px-3 py-2">{{ $loop->iteration }}</td>
                <td class="text-center px-3 py-2">{{ $row->asset->item_name ?? '-' }}</td>
                <td class="text-center px-3 py-2">
                    {{ $row->issue_date ? \Carbon\Carbon::parse($row->issue_date)->translatedFormat('d F Y') : '-' }}
                </td>
                <td class="text-center px-3 py-2 text-center">{{ ucfirst($row->maintenance_type) }}</td>
                <td class="text-center px-3 py-2 text-center">
                    @php
                        $priorityClass = match($row->priority) {
                            'Top Urgent' => 'badge bg-danger text-white fw-bold',   // Merah menyala
                            'Urgent'     => 'badge bg-warning text-dark fw-semibold', // Kuning-oranye
                            'Medium'     => 'badge bg-info text-dark fw-semibold',    // Biru muda
                            'Low'        => 'badge bg-success text-white fw-semibold',// Hijau
                            default      => 'badge bg-secondary text-white fw-medium',// Abu-abu default
                        };
                    @endphp

                    <span class="{{ $priorityClass }}">{{ $row->priority }}</span>
                </td>
                <td class="text-center px-3 py-2">{{ $row->cost ? number_format($row->cost,0,',','.') : '-' }}</td>
                <td class="px-3 py-2 text-center">
                    @php
                        $statusClass = match($row->status) {
                            'done' => 'badge bg-success',
                            'pending' => 'badge bg-warning text-dark',
                            'cancelled' => 'badge bg-danger',
                            default => 'badge bg-secondary'
                        };
                    @endphp
                    <span class="{{ $statusClass }}">{{ ucfirst($row->status) }}</span>
                </td>
                <td class="d-flex justify-content-end px-3 py-2" style="gap: 5px;">
                    <a href="{{ route('backend.asset-maintenance.show', $row->id) }}" class="btn btn-info btn-sm" title="Detail">
                        <i class="fas fa-eye"></i>
                    </a>

                    @if(auth()->check() && in_array(auth()->user()->role, [0,1,2]))
                    <a href="{{ route('backend.asset-maintenance.edit', $row->id) }}" class="btn btn-cyan btn-sm" title="Edit">
                        <i class="far fa-edit"></i>
                    </a>
                    <form method="POST" action="{{ route('backend.asset-maintenance.destroy', $row->id) }}" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-danger btn-sm show_confirm" 
                                data-konf-delete="{{ $row->asset->item_name ?? $row->id }}" 
                                title="Hapus">
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
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"/>
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
  $(document).ready(function() {
      $('#maintenanceTable').DataTable({
          ordering: true,
          searching: true,
          pageLength: 10,
          order: [[0, "asc"]],
          columnDefs: [
              { orderable: false, targets: -1 } // ❌ kolom terakhir ("Action") aja yang non-sort
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

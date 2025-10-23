<div class="card shadow-sm border-0">
  <div class="card-body">
    <h4 class="card-title mb-3">🎫 Data Asset Ticket</h4>
    <hr>

    <div class="mb-3">
      <a href="{{ route('backend.ticket.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Buat Ticket Baru
      </a>
    </div>

    <div class="table-responsive">
        <table id="assetticket_table" class="table table-hover table-striped table-bordered align-middle">
            <thead class="table-custom" style="background-color:#a4d0f4; color:#000; font-weight:normal; font-size:14px;">
            <tr>
                <th class="text-center">No Ticket</th>
                <th class="text-center">Item Name</th>
                <th class="text-center">Room</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Pelapor</th>
                <th class="text-center">Kategori</th>
                <th class="text-center">Prioritas</th>
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
            </tr>
            </thead>
            <tbody style="font-size:13px;">
            @foreach ($tickets as $row)
            <tr>
                <td class="text-center px-3 py-2">{{ $row->ticket_number }}</td>
                <td class="text-center px-3 py-2">
                    {{ $row->asset ? Str::limit($row->asset->item_name, 25) : '-' }}
                </td>
                <td class="text-center px-3 py-2">
                    {{ $row->asset && $row->asset->room ? $row->asset->room : '-' }}
                </td>
                <td class="text-center px-3 py-2">
                    {{ \Carbon\Carbon::parse($row->reported_at)->format('d M Y') }}
                </td>
                <td class="px-3 py-2">{{ $row->reporter_name ?? '-' }}</td>
                <td class="px-3 py-2 text-center">{{ $row->category ?? '-' }}</td>
                <td class="px-3 py-2 text-center">
                    @switch($row->priority)
                        @case('Critical')
                            <span class="badge" style="background-color:#d62828; color:#fff;">Critical</span>
                            @break
                        @case('High')
                            <span class="badge" style="background-color:#f77f00; color:#fff;">High</span>
                            @break
                        @case('Medium')
                            <span class="badge" style="background-color:#f9c74f; color:#000;">Medium</span>
                            @break
                        @case('Low')
                            <span class="badge" style="background-color:#90be6d; color:#000;">Low</span>
                            @break
                        @default
                            <span class="badge bg-secondary">-</span>
                    @endswitch
                </td>
                <td class="px-3 py-2 text-center">
                    @switch($row->status)
                        @case('Open')
                            <span class="badge bg-primary">Open</span>
                            @break
                        @case('In Progress')
                            <span class="badge" style="background-color:#f8961e;">In Progress</span>
                            @break
                        @case('Troubleshoot')
                            <span class="badge" style="background-color:#f9c74f; color:#000;">Troubleshoot</span>
                            @break
                        @case('Under Maintenance')
                            <span class="badge" style="background-color:#90be6d;">Under Maintenance</span>
                            @break
                        @case('Escalated')
                            <span class="badge" style="background-color:#9d4edd;">Escalated</span>
                            @break
                        @case('Resolved')
                            <span class="badge" style="background-color:#00b4d8;">Resolved</span>
                            @break
                        @case('Closed')
                            <span class="badge bg-dark">Closed</span>
                            @break
                        @default
                            <span class="badge bg-secondary">Unknown</span>
                    @endswitch
                </td>
                <td class="d-flex justify-content-end px-3 py-2" style="gap:5px;">
                    <a href="{{ route('backend.ticket.show', $row->id) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('backend.ticket.edit', $row->id) }}" class="btn btn-cyan btn-sm" title="Ubah Data">
                        <i class="far fa-edit"></i>
                    </a>
                    <form action="{{ route('backend.ticket.destroy', $row->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-danger btn-sm show_confirm" 
                                data-konf-delete="{{ $row->ticket_number }}" 
                                title="Hapus Ticket">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
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
      $('#assetticket_table').DataTable({
          ordering: true,
          searching: true,
          pageLength: 10,
          order: [[0, "asc"]],
          columnDefs: [
              { orderable: true, targets: 0 },
              { orderable: false, targets: '_all' }
          ],
          language: {
              lengthMenu: "Tampilkan _MENU_ data per halaman",
              zeroRecords: "Tidak ada ticket ditemukan",
              info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ ticket",
              infoEmpty: "Tidak ada ticket tersedia",
              infoFiltered: "(disaring dari _MAX_ total ticket)",
              search: "Cari:",
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

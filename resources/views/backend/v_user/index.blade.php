@extends('backend.v_layouts.app')

@section('content')
<div class="card shadow-sm border-0">
  <div class="card-body">
    <h4 class="card-title mb-3">👤 Data Employee</h4>
    <hr>

    <div class="mb-3">
      @if(auth()->check() && in_array(auth()->user()->role, [0,1,2]))
      <a href="{{ route('backend.user.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add 
      </a>
      @endif
    </div>

    <div class="table-responsive">
        <table id="userTable" class="table table-hover table-bordered align-middle">
            <thead class="table-custom" style="background-color:#dcdff5ff; color:#000; font-weight:normal; font-size:14px;">
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Email</th>
                <th class="text-center">Name</th>
                <th class="text-center">Role</th>
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
            </tr>
            </thead>
            <tbody style="font-size:13px;">
            @foreach ($index as $row)
            <tr>
                <td class="text-center px-3 py-2">{{ $loop->iteration }}</td>
                <td class="px-3 py-2">{{ $row->email }}</td>
                <td class="px-3 py-2">{{ $row->nama }}</td>
                <td class="px-3 py-2 text-center">
                    @switch($row->role)
                        @case(0)
                            <span class="badge" style="background-color:#f9c74f; color:#000;">Super Admin</span>
                            @break
                        @case(1)
                            <span class="badge" style="background-color:#48cae4; color:#000;">Admin IT</span>
                            @break
                        @case(2)
                            <span class="badge" style="background-color:#90be6d; color:#000;">Admin GA</span>
                            @break
                        @case(3)
                            <span class="badge" style="background-color:#e199e1ff; color:#000;">Staff</span>
                            @break
                        @default
                            <span class="badge bg-secondary">Unknown</span>
                    @endswitch
                </td>
                <td class="px-3 py-2 text-center">
                    @if (in_array($row->id, $onlineUsers))
                        <span class="badge" style="background-color:#90ee90; color:#000;">Aktif</span>
                    @else
                        <span class="badge" style="background-color:#d3d3d3; color:#000;">NonAktif</span>
                    @endif
                </td>
                <td class="d-flex justify-content-end px-3 py-2" style="gap: 5px;">
                    <a href="{{ route('backend.user.show', $row->id) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                        <i class="fas fa-eye"></i>
                    </a>

                    @if(auth()->check() && in_array(auth()->user()->role, [0]))
                    <a href="{{ route('backend.user.edit', $row->id) }}" class="btn btn-cyan btn-sm" title="Ubah Data">
                        <i class="far fa-edit"></i>
                    </a>
                    <form method="POST" action="{{ route('backend.user.destroy', $row->id) }}" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-danger btn-sm show_confirm" 
                                data-konf-delete="{{ $row->nama ?? $row->id }}" 
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
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"/>

@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
  $(document).ready(function() {
      $('#userTable').DataTable({
          ordering: true,
          searching: true,
          pageLength: 10,
          order: [[0, "asc"]], // default urut kolom No
          columnDefs: [
              { orderable: false, targets: 5 } // ❌ nonaktifkan sorting hanya di kolom "Action"
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

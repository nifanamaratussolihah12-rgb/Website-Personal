@extends('backend.v_layouts.app')

@section('content')
<div class="card shadow-sm border-0">
  <div class="card-body">
    <h4 class="card-title mb-3">📄 Daftar Formulir Permintaan Asset IT</h4>
    <hr>

    <div class="mb-3">
      <a href="{{ route('backend.assetrequest.create', 2) }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Add
      </a>
    </div>

    <div class="table-responsive">
        <table id="requestTable" class="table table-hover table-bordered align-middle">
            <thead class="table-custom" style="background-color:#dcdff5ff; color:#000; font-weight:normal; font-size:14px;">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">No Dokumen</th>
                    <th class="text-center">Tanggal Permintaan</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Catatan</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $key => $row)
                <tr>
                    <td class="text-center px-2 py-1" style="font-size:13px;">{{ $key + 1 }}</td>
                    <td class="text-center px-2 py-1" style="font-size:13px;">
                        {{ 'ITSI-AKM/RA.01/' . (!empty($row->tanggal) ? \Carbon\Carbon::parse($row->tanggal)->format('Y') : date('Y')) }}
                    </td>
                    <td class="text-center px-2 py-1" style="font-size:13px;">{{ $row->created_at?->format('d-m-Y') ?? 'N/A' }}</td>

                    {{-- STATUS --}}
                    <td class="text-center px-2 py-1" style="font-size:13px;">
                        @if($row->status == 'pending approval')
                            <span class="badge bg-warning text-dark">Pending Approval</span>
                        @elseif($row->status == 'approval')
                            <span class="badge bg-info text-white">Approval</span>
                        @elseif($row->status == 'done')
                            <span class="badge bg-success text-white">Done</span>
                        @else
                            <span class="badge bg-secondary">-</span>
                        @endif
                    </td>

                    {{-- CATATAN --}}
                    <td class="px-2 py-1" style="font-size:13px; max-width:200px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="{{ $row->catatan }}">
                        {{ $row->catatan ?? '-' }}
                    </td>

                    {{-- Action --}}
                    <td class="d-flex justify-content-center px-2 py-1" style="gap:5px; font-size:11px;">
                        <a href="{{ route('backend.assetrequest.show', $row->id) }}" 
                           class="btn btn-outline-secondary btn-sm d-flex align-items-center justify-content-center" 
                           style="width:36px; height:30px; font-size:11px;" title="Detail">
                            <i class="fas fa-eye" style="font-size:11px;"></i>
                        </a>

                        <a href="{{ route('backend.assetrequest.cetak', $row->id) }}" 
                           class="btn btn-outline-success btn-sm d-flex align-items-center justify-content-center" 
                           style="width:36px; height:30px; font-size:11px;" target="_blank" title="Cetak">
                            <i class="fas fa-print" style="font-size:11px;"></i>
                        </a>

                        @if(auth()->check() && in_array(auth()->user()->role, [0,1]))
                        <a href="{{ route('backend.assetrequest.edit', $row->id) }}" 
                           class="btn btn-outline-primary btn-sm d-flex align-items-center justify-content-center" 
                           style="width:36px; height:30px; font-size:11px;" title="Edit">
                            <i class="far fa-edit" style="font-size:11px;"></i>
                        </a>

                        <form action="{{ route('backend.assetrequest.destroy', $row->id) }}" method="POST" class="d-inline-flex align-items-center m-0 p-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm d-flex align-items-center justify-content-center show_confirm" 
                                    style="width:36px; height:30px; font-size:11px;" 
                                    data-konf-delete="{{ $row->created_at?->format('d-m-Y') }}" title="Hapus">
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

    <div class="text-center mt-3">
        <a href="{{ route('backend.asset-handover.index') }}" class="btn btn-secondary">Kembali</a>
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
      $('#requestTable').DataTable({
          ordering: true,
          searching: true,
          pageLength: 10,
          order: [[0, "asc"]],
        //   columnDefs: [
        //       { orderable: true, targets: 0 },
        //       { orderable: false, targets: '_all' }
        //   ],
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
              paginate: { first: "Pertama", last: "Terakhir", next: "›", previous: "‹" }
          }
      });
  });
</script>
@endpush

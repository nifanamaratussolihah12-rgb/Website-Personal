@extends('backend.v_layouts.app')

@section('content')
<div class="card shadow-sm border-0">
  <div class="card-body">
    <h4 class="card-title mb-3"><i class="fas fa-file-alt me-2 text-primary"></i> List of Documents</h4>
    <hr>

    <div class="table-responsive">
      <table id="documentTable" class="table table-hover table-bordered align-middle">
        <thead class="table-custom" style="background-color:#dcdff5ff; color:#000; font-weight:normal; font-size:14px;">
          <tr>
            <th class="text-center" style="width:50px;">No</th>
            <th class="text-center">Document Name</th>
            <th class="text-center" style="width:150px;">Action</th>
          </tr>
        </thead>
        <tbody style="font-size:13px;">
        @php
            $pendingCounts = [
                'Permintaan Asset IT' => \App\Models\AssetRequest::where('status', 'pending approval')->count(),
                'Serah Terima Asset IT' => \App\Models\AssetHandoverForm::where('status', 'pending approval')->count(),
                'Peralihan Asset IT' => \App\Models\AssetTransfer::where('status', 'pending approval')->count(),
                'Working Order' => \App\Models\WorkingOrder::where('status', 'pending approval')->count(),
                'Readiness/Kesiapan Instalasi' => \App\Models\InstallReadyForm::where('status', 'pending approval')->count(),
                'Finding' => \App\Models\Finding::where('status', 'pending approval')->count(),
                'Permintaan Perbaikan Perangkat IT (F3PIT)' => \App\Models\F3pit::where('status', 'pending approval')->count(),
                'Permintaan Login Email / Internet' => \App\Models\LoginRequest::where('status', 'pending approval')->count(),
                'Memo' => \App\Models\Memo::where('status', 'pending approval')->count(),
            ];

            $routes = [
                'Serah Terima Asset IT' => ['create' => 'backend.assethandoverforms.create', 'index' => 'backend.assethandoverforms.index', 'detail' => 'Detail'],
                'Peralihan Asset IT' => ['create' => 'backend.assettransfer.create', 'index' => 'backend.assettransfer.index', 'detail' => 'Detail Transfer'],
                'Working Order' => ['create' => 'backend.workingorder.create', 'index' => 'backend.workingorder.index', 'detail' => 'Detail'],
                'Permintaan Asset IT' => ['create' => 'backend.assetrequest.create', 'index' => 'backend.assetrequest.index', 'detail' => 'Detail'],
                'Readiness/Kesiapan Instalasi' => ['create' => 'backend.installreadyform.create', 'index' => 'backend.installreadyform.index', 'detail' => 'Detail'],
                'Finding' => ['create' => 'backend.finding.create', 'index' => 'backend.finding.index', 'detail' => 'Detail Finding'],
                'Permintaan Perbaikan Perangkat IT (F3PIT)' => ['create' => 'backend.f3pit.create', 'index' => 'backend.f3pit.index', 'detail' => 'Detail'],
                'Permintaan Login Email / Internet' => ['create' => 'backend.loginrequest.create', 'index' => 'backend.loginrequest.index', 'detail' => 'Detail'],
                'Memo' => ['create' => 'backend.memo.create', 'index' => 'backend.memo.index', 'detail' => 'Detail'],
            ];
        @endphp

        @foreach ($formulir as $row)
            @if(isset($routes[$row->nama_formulir]))
                <tr>
                    <td class="text-center px-3 py-2">{{ $loop->iteration }}</td>
                    <td class="px-3 py-2 fw-semibold">
                        {{ $row->nama_formulir }}

                        @if(isset($pendingCounts[$row->nama_formulir]) && $pendingCounts[$row->nama_formulir] > 0)
                            <span class="badge ms-2" style="background-color:#af1717ff; color:#ffffffff;">
                                {{ $pendingCounts[$row->nama_formulir] }}
                            </span>
                        @endif
                    </td>
                    <td class="d-flex justify-content-center px-3 py-2" style="gap:5px;">
                        <a href="{{ route($routes[$row->nama_formulir]['create'], $row->id) }}" 
                          class="btn btn-outline-primary btn-sm" 
                          data-bs-toggle="tooltip" title="Ajukan Form">
                            <i class="fas fa-clipboard"></i>
                        </a>
                        <a href="{{ route($routes[$row->nama_formulir]['index']) }}" 
                          class="btn btn-outline-secondary btn-sm" 
                          data-bs-toggle="tooltip" title="{{ $routes[$row->nama_formulir]['detail'] }}">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"/>
<style>
  th.no-sort::after, th.no-sort::before { display: none !important; }
  .table td, .table th { padding: 0.35rem 0.5rem; font-size: 15px; }
  .btn-sm { padding: 0.25rem 0.5rem; font-size: 12px; }
  .card-body { padding: 0.75rem 1rem; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
  $(document).ready(function() {
      $('#documentTable').DataTable({
    ordering: true,
    pageLength: 10,
    lengthChange: false, // hilangkan dropdown jumlah
    searching: true,     // search tetap aktif
    order: [[0, "asc"]],
    columnDefs: [
        { orderable: true, targets: 0 },
        { orderable: false, targets: '_all' }
    ],
    language: {
        zeroRecords: "Tidak ada data ditemukan",
        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        infoEmpty: "Tidak ada data tersedia",
        infoFiltered: "(disaring dari _MAX_ total data)",
        search: "Cari:",
        paginate: { first: "Pertama", last: "Terakhir", next: "›", previous: "‹" }
    }
});
</script>
@endpush

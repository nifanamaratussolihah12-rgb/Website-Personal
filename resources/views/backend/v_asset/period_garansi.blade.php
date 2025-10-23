@extends('backend.v_layouts.app')

@section('content')
<div class="card shadow-sm border-0">
  <div class="card-body">
    <h4 class="card-title mb-3">🕒 Period Garansi Asset</h4>
    <hr>

    <div class="table-responsive">
      <table id="tableGaransi" class="table table-bordered table-hover align-middle">
        <thead class="table-custom" style="background-color:#dcdff5ff; color:#000; font-weight:normal; font-size:14px;">
          <tr class="text-center">
            <th>No</th>
            <th>Nama Asset</th>
            <th>Room</th>
            <th>Merk</th>
            <th>Serial Number</th>
            <th>Official Store</th>
            <th>Reseller</th>
            <th>Tanggal Masuk</th>
            <th>Tanggal Expired</th>
            <th>Umur Asset</th>
            <th>Sisa Garansi</th>
            <th>Status Garansi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($asset as $i => $row)  
            <tr class="text-center">
              <td>{{ $i + 1 }}</td>
              <td>{{ $row->item_name ?? '-' }}</td>
              <td>{{ $row->room ?? '-' }}</td>
              <td>{{ $row->merk ?? '-' }}</td>
              <td>{{ $row->serial_number ?? '-' }}</td>
              <td>{{ $row->official_store ?? '-' }}</td>
              <td>{{ $row->reseller ?? '-' }}</td>
              <td>{{ $row->tanggal ? \Carbon\Carbon::parse($row->tanggal)->format('d F Y') : '-' }}</td>
              <td>{{ $row->warranty_expiry ? \Carbon\Carbon::parse($row->warranty_expiry)->format('d F Y') : '-' }}</td>
              <td>{{ $row->umur }}</td>
              <td>{{ $row->sisa_garansi }}</td>
              <td>
               @if ($row->status_garansi === 'Masih Bergaransi')
                <span class="badge" style="background-color:#198754; color:white;">{{ $row->status_garansi }}</span>
                @elseif ($row->status_garansi === 'Garansi Habis')
                <span class="badge" style="background-color:#dc3545; color:white;">{{ $row->status_garansi }}</span>
                @else
                <span class="badge" style="background-color:#6c757d; color:white;">{{ $row->status_garansi }}</span>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="11" class="text-center text-muted">Tidak ada data asset</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@push('scripts')

<script>
$(document).ready(function() {
  $('#tableGaransi').DataTable({
    "order": [], // biar bisa manual urut semua kolom
    "pageLength": 25,
    "columnDefs": [
      { "orderable": false, "targets": [] } // semua kolom bisa diurut
    ],
    "language": {
      "lengthMenu": "Tampilkan _MENU_ data per halaman",
      "zeroRecords": "Tidak ada data ditemukan",
      "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
      "infoEmpty": "Tidak ada data",
      "search": "Search:",
      "paginate": { "next": "➡️", "previous": "⬅️" }
    }
  });
});
</script>
@endpush

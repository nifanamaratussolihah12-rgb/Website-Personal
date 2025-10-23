@extends('backend.v_layouts.app')

@section('content')
<div class="card shadow-sm border-0">
  <div class="card-body">
    <h4 class="card-title mb-3">
      📂 Detail Type Asset: {{ $type_asset->nama_type }}
    </h4>
    <hr>

    <div class="table-responsive mt-3">
      <table id="typeAssetTable" class="table table-hover table-bordered align-middle">
        <thead class="table-custom text-center" style="background-color:#dcdff5ff; color:dark; font-weight:normal; font-size:14px;">
          <tr>
            <th>No</th>
            <th>Asset Type</th>
            <th>Code</th>
            <th>Asset Number</th>
            <th>Item Name</th>
            <th>User</th>
            <th>Departemen</th>
            <th>Qty</th>
            <th>Room</th>
            <th>Floor</th>
            <th>Site</th>
            <th>Merk</th>
            <th>Model</th>
            <th>Spek</th>
            <th>Kondisi</th>
            <th>Tanggal</th>
            <th>History</th>
            <th>Masa Garansi</th>
            <th>Official Store</th>
            <th>Reseller</th>
            <th>Nomor Seri</th>
            <th>Harga Beli</th>
            <th>Status</th>
            <th>Catatan</th>
          </tr>
        </thead>
        <tbody style="font-size:13px;">
          @forelse ($asset as $index => $item)
            <tr>
              <td class="text-center">{{ $index + 1 }}</td>
              <td>{{ $item->asset_type ?? '-'}}</td>
              <td>{{ $item->code ?? '-'}}</td>
              <td>{{ $item->asset_number ?? '-'}}</td>
              <td><strong>{{ $item->item_name ?? '-'}}</strong></td>
              <td>{{ $item->user ?? '-'}}</td>
              <td>{{ $item->departemen ?? '-'}}</td>
              <td class="text-center">{{ $item->qty ?? '-'}}</td>
              <td>{{ $item->room ?? '-'}}</td>
              <td>{{ $item->floor ?? '-'}}</td>
              <td>{{ $item->site ?? '-'}}</td>
              <td>{{ $item->merk ?? '-'}}</td>
              <td>{{ $item->model ?? '-'}}</td>
              <td>{{ $item->spek ?? '-'}}</td>
              <td>
                  @if($item->kondisi == 'baik')
                      <span class="badge badge-success">Baik</span>
                  @elseif($item->kondisi == 'layak pakai')
                      <span class="badge badge-warning">Layak Pakai</span>
                  @elseif($item->kondisi == 'rusak')
                      <span class="badge badge-danger">Rusak</span>
                  @else
                      -
                  @endif
              </td>
              <td>
                {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') : '-' }}
              </td>
              <td>{{ $item->history ?? '-'}}</td>
              <td>
                {{ $item->warranty_expiry ? \Carbon\Carbon::parse($item->warranty_expiry)->translatedFormat('d F Y') : '-' }}
              </td>
              <td>{{ $item->official_store ?? '-'}}</td>
              <td>{{ $item->reseller ?? '-'}}</td>
              <td>{{ $item->serial_number ?? '-'}}</td>
              <td>Rp {{ number_format($item->harga_beli ?? 0, 0, ',', '.') }}</td>
              <td>
                <span class="badge 
                  @if($item->status == 'new') bg-success 
                  @elseif($item->status == 'reclaim') bg-warning text-dark 
                  @else bg-secondary @endif">
                  {{ ucfirst($item->status) }}
                </span>
              </td>
              <td>{{ $item->catatan ?? '-' }}</td>
            </tr>
          @empty
            {{-- tbody kosong, DataTables akan otomatis menampilkan "No data available in table" --}}
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="text-center mt-3">
      <a href="{{ route('backend.asset.index') }}" class="btn btn-secondary">
        ← Kembali
      </a>
    </div>
  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css"/>
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

<script>
$(document).ready(function() {
    $('#typeAssetTable').DataTable({
        deferRender: true,      // render saat dibutuhkan, mencegah error saat tbody kosong
        autoWidth: false,       // mencegah warning column count
        ordering: true,
        searching: true,
        pageLength: 10,
        order: [[0, "asc"]],
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excel', className: 'btn btn-success btn-sm' }
        ],
        // columnDefs: [
        //     { orderable: true, targets: 0 },   // hanya kolom No bisa diurutkan
        //     { orderable: false, targets: '_all' }
        // ],
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

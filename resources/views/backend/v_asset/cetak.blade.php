<style>
  table {
    border-collapse: collapse;
    width: 100%;
    border: 1px solid #ccc;
  }

  table tr td,
  table tr th {
    padding: 6px;
    font-weight: normal;
    border: 1px solid #ccc;
  }

  table th {
    font-weight: bold;
    background-color: #f2f2f2;
  }
</style>

<table>
  <tr>
    <td align="left">
      Perihal : {{ $judul }} <br>
      Tanggal Awal : {{ $tanggalAwal }} s.d Tanggal Akhir {{ $tanggalAkhir }}
    </td>
  </tr>
</table>

<p></p>

<table>
  <thead>
    <tr>
      <th>No</th>
      <th>Foto</th>
      <th>Item Name</th>
      <th>Asset Number</th>
      <th>Qty</th>
      <th>Kategori</th>
      <th>Room</th>
      <th>Floor</th>
      <th>Merk</th>
      <th>Status</th>
      <th>Catatan</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($cetak as $row)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>
          @if ($row->foto)
            <img src="{{ public_path('storage/img-asset/' . $row->foto) }}" width="50px">
          @else
            <img src="{{ public_path('storage/img-asset/img-default.jpg') }}" width="50px">
          @endif
        </td>
        <td>{{ $row->item_name }}</td>
        <td>{{ $row->asset_number }}</td>
        <td>{{ $row->kategori->nama_kategori ?? '-' }}</td>
        <td>{{ $row->qty }}</td>
        <td>{{ $row->room ?? '-' }}</td>
        <td>{{ $row->floor ?? '-' }}</td>
         <td>{{ $row->merk ?? '-' }}</td>
         <td>{{ $row->catatan }}</td>
        <td>{{ ucfirst($row->status) }}</td>
      </tr>
    @endforeach
  </tbody>
</table>

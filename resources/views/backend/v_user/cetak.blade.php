<style>
  table {
    border-collapse: collapse;
    width: 100%;
    border: 1px solid #ccc;
    font-family: Arial, sans-serif;
    font-size: 14px;
  }

  table th,
  table td {
    padding: 6px;
    border: 1px solid #ccc;
    text-align: left;
  }

  table th {
    background-color: #f2f2f2;
    font-weight: bold;
  }
</style>

<table>
  <tr>
    <td align="left" style="border: none;">
      <strong>Perihal:</strong> {{ $judul }} <br>
      <strong>Tanggal Awal:</strong> {{ $tanggalAwal }} s.d <strong>Tanggal Akhir:</strong> {{ $tanggalAkhir }}
    </td>
  </tr>
</table>

<p></p>

<table>
  <thead>
    <tr>
      <th>No</th>
      <th>Nama</th>
      <th>Email</th>
      <th>Role</th>
      <th>NIK</th>
      <th>Divisi</th>
      <th>Site</th>
      <th>Date of Receive</th>
      <th>Term of Contract</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($cetak as $row)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $row->nama }}</td>
        <td>{{ $row->email }}</td>
        <td>
          @if ($row->role == 0)
            Admin
          @elseif ($row->role == 1)
            Staff
          @endif
        </td>
        <td>{{ $row->nik ?? '-' }}</td>
        <td>{{ $row->divisi ?? '-' }}</td>
        <td>{{ $row->site ?? '-' }}</td>
        <td>{{ $row->date_of_receive ? \Carbon\Carbon::parse($row->date_of_receive)->format('d-m-Y') : '-' }}</td>
      </tr>
    @endforeach
  </tbody>
</table>

@extends('backend.v_layouts.app')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title mb-4">Daftar Mapping Kode Asset</h4>

    <a href="{{ route('asset_code_mappings.create') }}" class="btn btn-primary mb-3">Tambah Mapping Baru</a>

    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Asset Type</th>
            <th>Type Code</th>
            <th>Item Name</th>
            <th>Item Code</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($mappings as $index => $mapping)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $mapping->asset_type }}</td>
            <td>{{ $mapping->type_code }}</td>
            <td>{{ $mapping->item_name }}</td>
            <td>{{ $mapping->item_code }}</td>
            <td>
              <a href="{{ route('asset_code_mappings.edit', $mapping->id) }}" class="btn btn-sm btn-warning">Edit</a>
              <form action="{{ route('asset_code_mappings.destroy', $mapping->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-sm btn-danger">Hapus</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center">Belum ada data mapping kode.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

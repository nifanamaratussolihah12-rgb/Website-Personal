@extends('v_layouts.backend')

@section('content')
<div class="container">
    <h1>Tambah Consumable Goods</h1>
    <form action="{{ route('consumable.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @include('backend.v_consumable.form')

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection

@extends('v_layouts.backend')

@section('content')
<div class="container">
    <h1>✏️ Edit Consumable Goods</h1>
    <form action="{{ route('consumable.update', $consumable->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('backend.v_consumable.form')

        <button type="submit" class="btn btn-warning">Update</button>
    </form>
</div>
@endsection

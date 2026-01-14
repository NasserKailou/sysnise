@extends('admin.layout')

@section('content')
<h3>Modifier la permission : {{ $permission->name }}</h3>
<form method="POST" action="{{ route('admin.permissions.update', $permission) }}">
  @csrf @method('PUT')
  <div class="mb-3">
    <label>Nom</label>
    <input name="name" class="form-control" value="{{ $permission->name }}" required>
  </div>
  <div class="mb-3">
    <label>Label</label>
    <input name="label" class="form-control" value="{{ $permission->label }}">
  </div>
  <button class="btn btn-success">Mettre à jour</button>
</form>
@endsection

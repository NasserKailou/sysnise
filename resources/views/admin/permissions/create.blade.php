@extends('admin.layout')

@section('content')
<h3>Nouvelle permission</h3>
<form method="POST" action="{{ route('admin.permissions.store') }}">
  @csrf
  <div class="mb-3">
    <label>Nom</label>
    <input name="name" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Label</label>
    <input name="label" class="form-control">
  </div>
  <button class="btn btn-success">Créer</button>
</form>
@endsection

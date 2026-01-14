@extends('admin.layout')

@section('content')
<h3>Créer un rôle</h3>
<form method="POST" action="{{ route('admin.roles.store') }}">
  @csrf
  <div class="mb-3">
    <label>Nom</label>
    <input name="name" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Label (optionnel)</label>
    <input name="label" class="form-control">
  </div>

  <div class="mb-3">
    <label>Permissions</label><br>
    @foreach($permissions as $p)
      <label class="me-3">
        <input type="checkbox" name="permissions[]" value="{{ $p->id }}"> {{ $p->name }}
      </label>
    @endforeach
  </div>

  <button class="btn btn-success">Enregistrer</button>
  <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Annuler</a>
</form>
@endsection

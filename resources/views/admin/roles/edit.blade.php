@extends('admin.layout')

@section('content')
<h3>Modifier le rôle : {{ $role->name }}</h3>
<form method="POST" action="{{ route('admin.roles.update', $role) }}">
  @csrf @method('PUT')

  <div class="mb-3">
    <label>Nom</label>
    <input name="name" class="form-control" value="{{ $role->name }}" required>
  </div>
  <div class="mb-3">
    <label>Label</label>
    <input name="label" class="form-control" value="{{ $role->label }}">
  </div>

  <div class="mb-3">
    <label>Permissions</label><br>
    @foreach($permissions as $p)
      <label class="me-3">
        <input type="checkbox" name="permissions[]" value="{{ $p->id }}"
          {{ in_array($p->id, $rolePermissions) ? 'checked' : '' }}> {{ $p->name }}
      </label>
    @endforeach
  </div>

  <button class="btn btn-success">Mettre à jour</button>
  <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Annuler</a>
</form>
@endsection

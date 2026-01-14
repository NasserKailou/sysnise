@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Liste des rôles</h3>
    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">+ Nouveau rôle</a>
</div>

<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Nom</th>
      <th>Label</th>
      <th>Permissions</th>
      <th width="150">Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach($roles as $role)
    <tr>
      <td>{{ $role->name }}</td>
      <td>{{ $role->label }}</td>
      <td>
        @foreach($role->permissions as $perm)
          <span class="badge bg-info text-dark">{{ $perm->name }}</span>
        @endforeach
      </td>
      <td>
        <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-warning">Éditer</a>
        <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" style="display:inline">
          @csrf @method('DELETE')
          <button onclick="return confirm('Supprimer ce rôle ?')" class="btn btn-sm btn-danger">Suppr.</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

{{ $roles->links() }}
@endsection

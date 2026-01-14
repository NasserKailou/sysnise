@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between mb-3">
  <h3>Liste des permissions</h3>
  <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">+ Nouvelle permission</a>
</div>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>Nom</th>
      <th>Label</th>
      <th width="150">Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach($permissions as $perm)
    <tr>
      <td>{{ $perm->name }}</td>
      <td>{{ $perm->label }}</td>
      <td>
        <a href="{{ route('admin.permissions.edit', $perm) }}" class="btn btn-sm btn-warning">Éditer</a>
        <form method="POST" action="{{ route('admin.permissions.destroy', $perm) }}" style="display:inline">
          @csrf @method('DELETE')
          <button onclick="return confirm('Supprimer ?')" class="btn btn-sm btn-danger">Suppr.</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

{{ $permissions->links() }}
@endsection

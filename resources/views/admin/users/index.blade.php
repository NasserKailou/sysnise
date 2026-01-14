@extends('admin.layout')

@section('content')
<h3>Gestion des rôles utilisateurs</h3>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>Utilisateur</th>
      <th>Email</th>
      <th>Rôles</th>
      <th>Assigner</th>
    </tr>
  </thead>
  <tbody>
    @foreach($users as $user)
    <tr>
      <td>{{ $user->name }}</td>
      <td>{{ $user->email }}</td>
      <td>
        @foreach($user->roles as $role)
          <span class="badge bg-primary">{{ $role->name }}</span>
        @endforeach
      </td>
      <td>
        <form method="POST" action="{{ route('admin.users.updateRoles', $user) }}">
          @csrf
          @foreach($roles as $r)
            <label class="me-2">
              <input type="checkbox" name="roles[]" value="{{ $r->id }}"
                     {{ $user->roles->contains($r->id) ? 'checked' : '' }}>
              {{ $r->name }}
            </label>
          @endforeach
          <button class="btn btn-sm btn-success mt-2">Mettre à jour</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

{{ $users->links() }}
@endsection

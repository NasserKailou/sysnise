@extends('admin.layout')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-warning">
            <h4 class="mb-0 text-white">Modifier l’utilisateur</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nom complet</label>
                    <input type="text" name="name" id="name" class="form-control" 
                           value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email</label>
                    <input type="email" name="email" id="email" class="form-control" 
                           value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mot de passe (laisser vide pour ne pas changer)</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirmation du mot de passe</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Rôles attribués</label>
                    <div class="row">
                        @foreach($roles as $role)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        name="roles[]" 
                                        value="{{ $role->id }}" 
                                        id="role_{{ $role->id }}"
                                        {{ in_array($role->id, $userRoleIds) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="text-end">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-warning text-white">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

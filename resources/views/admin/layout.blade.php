<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Administration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('admin.roles.index') }}">Admin</a>
    <ul class="navbar-nav">
      <li class="nav-item"><a href="{{ route('admin.roles.index') }}" class="nav-link">Rôles</a></li>
      <li class="nav-item"><a href="{{ route('admin.permissions.index') }}" class="nav-link">Permissions</a></li>
      <li class="nav-item"><a href="{{ route('admin.users.index') }}" class="nav-link">Utilisateurs</a></li>
    </ul>
  </div>
</nav>

<div class="container">
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @yield('content')
</div>
</body>
</html>

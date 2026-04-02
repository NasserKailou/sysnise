<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">{{ $breadcrumb?? '' }}</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ms-auto">
		<!-- Icône utilisateur -->
		<li class="nav-item">
			<a class="nav-link" href="#" role="button">
				<i class="fas fa-user"></i>
			</a>
		</li>

		<!-- Bouton déconnexion -->
		<li class="nav-item">
			<form action="{{ route('logout') }}" method="get" class="d-inline">
				@csrf
				<button type="submit" class="nav-link btn btn-link" style="text-decoration:none;">
					<i class="fas fa-sign-out-alt"></i> Déconnexion
				</button>
			</form>
		</li>
	</ul>
</nav>
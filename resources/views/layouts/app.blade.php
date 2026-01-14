<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
	 
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Styles AdminLTE -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- Styles personnalisés -->
    @stack('css')
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/zTree.v3/3.5.42/css/zTreeStyle/zTreeStyle.min.css" integrity="sha512-W3T+ffBp2PURTmeY0dPZuakhOCElWnf2IJsDJnD/wUXkqrDedFvxxuDURSKU2KpDRym04aB3B9Esl+ti1lTBcg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
	<link href="https://cdn.datatables.net/v/bs5/dt-2.1.6/r-3.0.3/datatables.min.css" rel="stylesheet"/>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
	
	<!-- Font Awesome pour les icônes -->
	
	<style>
    body {
      background-color: #f8f9fa;
    }
	
	.ztree li input{
		min-width: 30ch;
		width: fit-content;
		height: 20px !important;
		padding-left:5px !important;
	}
    .ztree li a.curSelectedNode{
		padding:left:5px;
		height: auto;
	}
	.ztree li a{
		height: auto !important;
	}
	/*.ztree li span.button.switch {
		height: auto;
	}*/
	
    /* Section de formulaire */
    .form-section {
      background: #fff;
      padding: 20px;
      border-radius: 6px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      margin-bottom: 20px;
    }
    .section-title {
      font-weight: bold;
      background-color: #f8f9fa;
      padding: 8px;
      border-left: 3px solid #0d6efd;
      margin-bottom: 15px;
    }
	.page-title {
      font-weight: bold;
      background-color: #fff;
      padding: 8px;
      border-left: 3px solid #0d6efd;
      margin-bottom: 15px;
    }
	.table-icons {
		white-space: nowrap;
		width: 1%;
	}
  </style>
	 
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    @include('layouts.navbar')

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        
        <!-- Main content -->
        <section class="content mt-3">
            <div class="container-fluid">
			  @if(session('success'))
				<div class="alert alert-success alert-dismissible fade show" role="alert">
				  {{ session('success') }}
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
				</div>
			  @endif
			
			  @if(session('error'))
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
				  <strong>Échec :</strong> veuillez corriger les erreurs ci-dessous. <br> {{ session('error') }}
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
				</div>
			  @endif

			  @yield('content')
			</div>
        </section>
    </div>
	<div id="popup"> </div>
    <!-- Footer -->
    @include('layouts.footer')

</div>

<!-- Scripts AdminLTE -->
<!-- jQuery 
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
-->
<!-- Bootstrap 4 -->
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE -->
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>

<!-- Dans l'ordre -->
<!--
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
-->
<script src="https://cdn.datatables.net/v/bs5/dt-2.1.6/r-3.0.3/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/zTree.v3/3.5.42/js/jquery.ztree.all.min.js" integrity="sha512-7sGF7QJRDdvZna4GfwsdoY6a8jxCFZTAlL2OFKjmEXZ9mPwzHbKnwDiIy9RI1hYZv+XLtbOew+6slAJahxaH+Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- DataTables Buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<!-- Scripts personnalisés -->
@stack('js')
<script>

$(document).ready(function() {
  $('.dataTable').DataTable({
	"pageLength": 10,
    "autoWidth": false
  });
});
	
document.addEventListener('DOMContentLoaded', function() {
	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
	var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
		return new bootstrap.Tooltip(tooltipTriggerEl)
	});
	// Initialisation des modales
	var modals = document.querySelectorAll('.modal');
	modals.forEach(function(modal) {
		modal.addEventListener('shown.bs.modal', function() {
			// Focus sur le premier champ input de la modale
			var input = modal.querySelector('input');
			if (input) input.focus();
		});
	});

	// Gestion des messages flash
	setTimeout(function() {
		var alerts = document.querySelectorAll('.alert');
		alerts.forEach(function(alert) {
			alert.style.transition = 'opacity 1s';
			alert.style.opacity = '0';
			setTimeout(function() {
				alert.remove();
			}, 1000);
		});
	}, 3000);
});
</script>
</body>
</html>
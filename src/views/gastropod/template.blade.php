<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>GASTROPOD</title>

	<!-- BOOTSTRAP CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
		integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<!-- BOOTSTRAP ICONS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
	<!-- CUSTOM CSS -->
	<link rel="stylesheet" href="{{ asset('/css/gastropod.css') }}">



</head>

<body>
	@if (Auth::user() && Auth::user()->gastronaut == true)
	<header>
		<!-- Fixed navbar -->
		<nav class="navbar navbar-expand-md navbar-dark bg-dark">
			<div class="container-fluid">
				<img src="{{ asset('/img/gastropod.png') }}" class="img-fluid" style="width:50px;" />
				 &nbsp;&nbsp;<a class="navbar-brand" href="/gastropod/users"> ••G@STROPOD•• </a> 
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
					aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarCollapse">
					<ul class="navbar-nav me-auto mb-2 mb-md-0">
						<li class="nav-item">
							<a class="nav-link" aria-current="page" href="/gastropod/users">Users</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" aria-current="page" href="/gastropod/profiles">Profiles</a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="/gastropod/maps" id="navbarDropdown" role="button"
								data-bs-toggle="dropdown" aria-expanded="false">
								Maps
							</a>
							<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
								<li><a class="dropdown-item" href="/gastropod/maps">Maps</a></li>
								<li><a class="dropdown-item" href="/gastropod/map_user">Maps x User</a></li>
								<li>
									<hr class="dropdown-divider">
								</li>
								<li><a class="dropdown-item" href="#">Niente</a></li>
							</ul>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/gastropod/admins">Admins</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/gastropod/logout">Logout</a>
						</li>
					</ul>
					<!--<form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>-->
				</div>
			</div>
		</nav>
	</header>
	@endif


	<div class="container-fluid" style="margin-bottom:100px;margin-top:20px;">
		@yield('content')
	</div>

	<footer class="footer mt-auto py-3 bg-dark fixed-bottom mt-9">
		<div class="container text-center">
			<span class="text-muted">G@STROPOD v.0.0.1</span>
		</div>
	</footer>


	<!-- JQUERY -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"
		integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<!-- BOOTSTRAP -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
		integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
	</script>
	<!-- G@STROPOD -->
	<script src="{{ asset('/js/gastropod.js') }}"></script>
</body>

</html>
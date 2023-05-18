<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<title>Login | PEKERTI</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
	<meta content="Themesdesign" name="author" />
	<!-- App favicon -->
	<link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

	<!-- Bootstrap Css -->
	<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<!-- Icons Css -->
	<link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
	<!-- App Css-->
	<link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
	<!-- Selectize -->
	<link href="{{ asset('assets/libs/selectize/css/selectize.css') }}" rel="stylesheet" type="text/css" />

</head>

<body class="bg-primary bg-pattern">

	<div class="account-pages my-3">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="text-center mb-2">
						<a href="/" class="logo"><img src="/images/logo.jpg" height="24" alt="logo"></a>
					</div>
				</div>
			</div>
			<!-- end row -->

			<div class="row justify-content-center">
				<div class="col-xl-5 col-sm-8">
					<div class="card">
						<div class="card-body p-4">
							<div class="p-2">
								<h5 class="mb-3 text-center">Login untuk melanjutkan.</h5>
								<form method="POST" class="form-horizontal" action="/login">
									@csrf
									<div class="row">
										<div class="col-md-12">
											@if (Session::has('register'))
												<div class="alert alert-success mb-3">{{ Session::get('register') }}</div>	
											@endif

											@if (Session::has('verify'))
													<div class="alert alert-success mb-3">{{ Session::get('verify') }}</div>
											@endif

											@if (Session::has('message'))
												<div class="alert alert-danger mb-3">{{ Session::get('message') }}</div>
											@endif
											<div class="form-group form-group-custom mb-4">
												<input type="email" class="form-control" id="email" name="email" required>
												<label for="email">Email</label>
											</div>

											<div class="form-group form-group-custom mb-4">
												<input type="password" class="form-control" id="password" name="password" required>
												<label for="password">Password</label>
											</div>

											<div class="form-group form-group-custom mb-4">
												<select name="role" class="form-control" required>
													<option value="">Pilih Peran...</option>
													<option value="admin">Admin</option>
													<option value="dosen">Dosen</option>
												</select>
											</div>

											<div class="mt-4">
												<button class="btn btn-success btn-block waves-effect waves-light" type="submit">Log In</button>
											</div>
											<div class="mt-4 text-center">
												<a href="/register" class="text-muted"><i class="mdi mdi-account-circle mr-1"></i>
													Buat Akun Baru</a>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- end row -->
		</div>
	</div>
	<!-- end Account pages -->

	<!-- JAVASCRIPT -->
	<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
	<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
	<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
	<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
	<script src="{{ asset('assets/libs/selectize/js/standalone/selectize.min.js') }}"></script>
	<script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>
	<script src="https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js"></script>
	<script src="{{ asset('assets/js/app.js') }}"></script>

</body>

</html>
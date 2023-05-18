<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Register | PEKERTI</title>
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
                <h5 class="mb-3 text-center">Daftar Akun PEKERTI Baru</h5>
                <form method="POST" class="form-horizontal" action="/register">
                  @csrf
                  <div class="row">
                    <div class="col-md-12">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                          @if ($error == "validation.unique")
                            <div class="alert alert-danger mb-4">Email sudah terdaftar, silahkan menggunakan email lain.</div>  
                          @endif

                          @if ($error == "validation.min.string")
                            <div class="alert alert-danger mb-4">Kata Sandi minimal 8 karakter.</div>
                          @endif

                          @if ($error == "The password must contain at least one uppercase and one lowercase letter.")
                            <div class="alert alert-danger mb-4">Kata Sandi harus mengandung karakter 1 huruf kapital dan 1 karakter huruf kecil.</div>
                          @endif

                          @if ($error == "The password must contain at least one number.")
                            <div class="alert alert-danger mb-4">Kata Sandi harus mengandung karakter numerik.</div>
                          @endif
                        @endforeach
                    @endif
                      <div class="form-group form-group-custom mb-4">
                        <input type="text" class="form-control" id="email" name="fullname" required>
                        <label for="email">Nama Lengkap</label>
                      </div>
                      <div class="form-group form-group-custom mb-4">
                        <input type="email" class="form-control" id="useremail" name="email" required>
                        <label for="useremail">Email</label>
                      </div>
                      <div class="form-group form-group-custom mb-4">
                        <input type="password" class="form-control" id="userpassword" name="password" required>
                        <label for="userpassword">Kata Sandi</label>
                      </div>
                      <div class="mt-4">
                        <button class="btn btn-success btn-block waves-effect waves-light"
                          type="submit">Daftar</button>
                      </div>
                      <div class="mt-4 text-center">
                        <a href="/login" class="text-muted"><i class="mdi mdi-account-circle mr-1"></i> Sudah
                          punya akun?</a>
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
	<script src="https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js"></script>
	<script src="{{ asset('assets/js/app.js') }}"></script>

</body>

</html>
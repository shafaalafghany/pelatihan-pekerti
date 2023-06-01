<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Tambah Kolom Penilaian {{ $pelatihan->nama }} | Pelatihan PEKERTI-AA</title>
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

<body data-topbar="colored">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="/" class="logo logo-dark">
                            <span class="logo-lg">
                                <img src="/images/logo.jpg" alt="" height="22">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="mdi mdi-backburger"></i>
                    </button>

                </div>

                <div class="d-flex">

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="/images/default.jpg"
                                alt="Header Avatar">
                            <span class="d-none d-sm-inline-block ml-1">{{ $user['name'] }}</span>
                            <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a class="dropdown-item" href="#"><i
                                    class="mdi mdi-face-profile font-size-16 align-middle mr-1"></i> Profil</a>
                            <div class="dropdown-divider"></div>
                            <form id="logout" action="/logout" method="POST">
                                @csrf
                                <a class="dropdown-item" href="javascript:{}"
                                    onclick="document.getElementById('logout').submit()"><i
                                        class="mdi mdi-logout font-size-16 align-middle mr-1"></i> Logout</a>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

        </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <div data-simplebar class="h-100">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title">Menu</li>

                        <li>
                            <a href="/" class="waves-effect">
                                <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-warehouse mdi-24px"></i>
                                </div>
                                <span>Beranda</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <div class="d-inline-block icons-sm mr-1"><i
                                        class="mdi mdi-view-grid-outline mdi-24px"></i></div>
                                <span>Pelatihan</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/admin/dashboard/pelatihan">Daftar Pelatihan</a></li>
                                <li><a href="/admin/dashboard/sesi">Sesi</a></li>
                                <li><a href="/admin/dashboard/presensi">Presensi</a></li>
                                <li><a href="/admin/dashboard/tugas">Tugas</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="/admin/dashboard/validasi-berkas" class="waves-effect">
                                <div class="d-inline-block icons-sm mr-1"><i
                                        class="mdi mdi mdi-file-multiple-outline mdi-24px"></i>
                                </div>
                                <span>Validasi Berkas</span>
                            </a>
                        </li>

                        @if ($user['role'] == 'superadmin')
                            <li>
                                <a href="/admin/dashboard/tambah-admin" class="waves-effect">
                                    <div class="d-inline-block icons-sm mr-1"><i
                                            class="mdi mdi-account-multiple-plus-outline mdi-24px"></i>
                                    </div>
                                    <span>Tambah Admin</span>
                                </a>
                            </li>
                        @endif

                    </ul>

                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">

                <!-- Page-Title -->
                <div class="page-title-box">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="page-title mb-1">Tambah Kolom Penilaian</h4>
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="/admin/dashboard/pelatihan">Pelatihan</a></li>
                                    <li class="breadcrumb-item"><a
                                            href="/admin/dashboard/pelatihan/{{ $pelatihan->id }}">Detail
                                            {{ $pelatihan->nama }}</a></li>
                                    <li class="breadcrumb-item active">Tambah Kolom Nilai</li>
                                </ol>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- end page title end breadcrumb -->

                <div class="page-content-wrapper">
                    <div class="container-fluid">
                        <div class="col">
                            <div class="card">
                                <!-- selamat datang card -->
                                <div class="card-body">
                                    <div class="col">

                                        <h4>Tambah Kolom Penilaian {{ $pelatihan->nama }}</h4>

                                        @if (Session::has('type') && Session::has('message'))
                                            <div class="alert alert-{{ Session::get('type') }}">
                                                {{ Session::get('message') }}</div>
                                        @elseif (Session::has('message'))
                                            <div class="alert alert-success">{{ Session::get('message') }}</div>
                                        @endif

                                        <strong>Nama Pelatihan: </strong> {{ $pelatihan->nama }} <br>
                                        <strong>Jenis Pelatihan: </strong>
                                        {{ strtoupper($pelatihan->jenis_pelatihan) }}
                                        <br>
                                        <div class="mb-5">
                                            <h6><b>Kolom nilai yang telah ditambahkan:</b></h6>
                                            @if (count($kolom) == 0)
                                                &ensp;<strong>Belum ada kolom nilai yang ditambahkan</strong>
                                            @else
                                                <ul>
                                                    @foreach ($kolom as $item)
                                                        &ensp;<li><strong>{{ $item->nama_nilai }}</strong></li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>

                                        <h5>Tambah Kolom Nilai</h5>
                                        <form action="/nilai/tambah-kolom" method="POST">
                                            @csrf
                                            <input class="form-control" type="text" name="pelatihan"
                                                value="{{ $pelatihan->id }}" hidden>
                                            <div class="form-group row">
                                                <label class="col-md-2 col-form-label">Nama Kolom Nilai*</label>
                                                <div class="col-md-10 mb-3">
                                                    <input class="form-control" type="text" name="kolom_nilai"
                                                        required>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary btn-block waves-effect waves-light w-25"
                                                type="submit">Simpan</button>
                                        </form>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div> <!-- container-fluid -->
                </div>
                <!-- end page-content-wrapper -->
            </div>
            <!-- End Page-content -->


            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            2020 © Xoric.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-right d-none d-sm-block">
                                Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesdesign
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

    <script src="https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js"></script>

    <script src="{{ asset('assets/js/pages/dashboard.init.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>

</body>

</html>

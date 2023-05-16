<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Beranda | Pelatihan PEKERTI-AA</title>
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
                            <a href="index.html" class="logo logo-dark">
                                <span class="logo-lg">
                                    <img src="/images/logo.jpg" alt="" height="22">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                            <i class="mdi mdi-backburger"></i>
                        </button>

                    </div>

                    <div class="d-flex">

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="{{ $user['foto_profil'] == null ? '/images/default.jpg' : '/images/foto-profil/' . $user['foto_profil']; }}" alt="Header Avatar">
                                <span class="d-none d-sm-inline-block ml-1">{{ $user['fullname'] }}</span>
                                <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <!-- item-->
                                <a class="dropdown-item" href="/dashboard/profil"><i class="mdi mdi-face-profile font-size-16 align-middle mr-1"></i> Profil</a>
                                <div class="dropdown-divider"></div>
                                <form id="logout" action="/logout" method="POST">
                                  @csrf
                                  <a class="dropdown-item" href="javascript:{}" onclick="document.getElementById('logout').submit()"><i class="mdi mdi-logout font-size-16 align-middle mr-1"></i> Logout</a>
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
                                    <div class="d-inline-block icons-sm mr-1"><i class="uim uim-airplay"></i></div>
                                    <span>Beranda</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <div class="d-inline-block icons-sm mr-1"><i class="uim uim-apps"></i></div>
                                    <span>Pelatihan</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="/dashboard/pelatihan">Daftar Pelatihan</a></li>
                                    <li><a href="/dashboard/sesi">Sesi</a></li>
                                    <li><a href="/dashboard/presensi">Presensi</a></li>
                                    <li><a href="/dashboard/tugas">Tugas</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="/dashboard/pembayaran" class="waves-effect">
                                    <div class="d-inline-block icons-sm mr-3"><i class="ti-money"></i></div>
                                    <span>Pembayaran</span>
                                </a>
                            </li>

                            <li>
                                <a href="/dashboard/cetak-dokumen" class="waves-effect">
                                    <div class="d-inline-block icons-sm mr-1"><i class="uim uim-paperclip"></i></div>
                                    <span>Cetak Dokumen dan Riwayat Tes</span>
                                </a>
                            </li>

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
                                    <h4 class="page-title mb-1">Dasbor</h4>
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                                      <li class="breadcrumb-item active">Beranda Aplikasi PEKERTI-AA</li>
                                      </ol>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- end page title end breadcrumb -->

                    <div class="page-content-wrapper">
                        <div class="container-fluid"> 
                            <div class="col">
                                <div class="card"> <!-- selamat datang card -->
                                    <div class="card-body">
                                        <div class="col-5">
                                            <h5>Selamat Datang Kembali, {{ $user['fullname'] }}!</h5>
                                            @if ($user['id_pelatihan'] == 0)
                                              <h6 class="text-muted">Anda belum terdaftar di pelatihan mana pun.</h6>
                                            @else
                                              <h6 class="text-muted">Anda sedang terdaftar pada {{ $pelatihan['nama'] }}</h6>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="card">  <!-- profil card -->
                                    <div class="card-body">
                                        <div class="col">
                                            <div class="mb-4">
                                                <a href="/dashboard/profil/edit-profil" class="btn btn-primary">Perbarui Profil</a>
                                            </div>

                                            <div class="table-responsive-md">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <td><b>Email</b></td>
                                                            <td>{{ $user['email'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>NIK (Nomor Induk Kependudukan)</b></td>
                                                            <td>{{ $user['nik'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>NIDN/NIDK (Nomor Induk Dosen Nasional)</b></td>
                                                            <td>{{ $user['nidn_nidk'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Gelar Sebelum Nama</b></td>
                                                            <td>{{ $user['gelar_depan'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Nama Lengkap</b></td>
                                                            <td>{{ $user['fullname'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Gelar Setelah Nama</b></td>
                                                            <td>{{ $user['gelar_belakang'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Nama Instansi</b></td>
                                                            <td>{{ $user['nama_instansi'] }}</td>
                                                        </tr>
                                                        <tr>
                                                          <td><b>Jenis Kelamin</b></td>
                                                          <td>{{ $user['jenis_kelamin'] }}</td>
                                                        </tr>
                                                        <tr>
                                                          <td><b>Tempat Lahir</b></td>
                                                          <td>{{ $user['tempat_lahir'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Tanggal Lahir</b></td>
                                                            <td>{{ $user['tanggal_lahir'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Nama Instansi</b></td>
                                                            <td>{{ $user['nama_instansi'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Alamat</b></td>
                                                            <td>{{ $user['alamat'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Provinsi</b></td>
                                                            <td>{{ $user['provinsi'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Kota</b></td>
                                                            <td>{{ $user['kota'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Kode Pos</b></td>
                                                            <td>{{ $user['kode_pos'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Telepon</b></td>
                                                            <td>{{ $user['telepon'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Foto Profil</b></td>
                                                            <td><img src="{{ $user['foto_profil'] == null ? '/images/default.jpg' : '/images/foto-profil/' . $user['foto_profil']; }}" style="max-width:100%;height:auto" width="354" height="472"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                @if ($user['id_pelatihan'] != 0)

                                <div class="card"> <!-- tugas card -->
                                    <div class="card-body">
                                        <div class="col">
                                            <h5>Tugas</h5>
                                            
                                            <div class="table-responsive-md">
                                                <table class="table md-0">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Nama Tugas</th>
                                                            <th>Batas Pengumpulan</th>
                                                            <th>Status Pengumpulan</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>Tugas Sesi 1</td>
                                                            <td>20.00 WIB, 1 November 2022</td>
                                                            <td>Sudah Mengumpulkan</td>
                                                            <td><a type="button" class="btn btn-primary waves-effect waves-light text-light" href="tugas-detail.html">Lihat Tugas</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>2</td>
                                                            <td>Tugas Sesi 2</td>
                                                            <td>20.00 WIB, 30 November 2022</td>
                                                            <td class="text-danger">Belum Mengumpulkan</td>
                                                            <td><a type="button" class="btn btn-primary waves-effect waves-light text-light" href="tugas-detail.html">Lihat Tugas</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>3</td>
                                                            <td>Tugas Sesi 3</td>
                                                            <td>20.00 WIB, 30 November 2022</td>
                                                            <td>Sudah Mengumpulkan</td>
                                                            <td><a type="button" class="btn btn-primary waves-effect waves-light text-light" href="tugas-detail.html">Lihat Tugas</button></td>
                                                        </tr>
                                                        <tr>
                                                            <td>4</td>
                                                            <td>Tugas Sesi</td>
                                                            <td>20.00 WIB, 30 November 2022</td>
                                                            <td>Telat Mengumpulkan</td>
                                                            <td><a type="button" class="btn btn-primary waves-effect waves-light text-light" href="tugas-detail.html">Lihat Tugas</button></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                              
                              @endif

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

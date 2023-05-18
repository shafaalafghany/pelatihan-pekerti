<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Cek Data Diri | Pelatihan PEKERTI-AA</title>
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
                <h4 class="page-title mb-1">Cek Data Diri</h4>
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="/dashboard/pelatihan">Pelatihan</a></li>
                  <li class="breadcrumb-item active">Daftar {{ $pelatihan['nama'] }}</li>
                  <li class="breadcrumb-item active">Cek Data Diri {{ $user['fullname'] }}</li>
                </ol>
              </div>
            </div>

          </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="page-content-wrapper">
          <div class="container-fluid">
            <div class="col">
              <div class="card"> <!-- profil card -->
                <div class="card-body">
                  <div class="col">

                    <h4 class="mb-3">Cek Data Diri</h4>

                    @if (count($errors) > 0)
                      @foreach ($errors->all as $error)
                          <div class="alert alert-danger">{{ $error }}</div>
                      @endforeach
                    @endif

                    <form action="/pelatihan/daftar/{{ $pelatihan['id'] }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <h4 class="header-title">Data Personal</h4>

                      <div class="form-group row">
                        <label class="col-md-2 col-form-label">Email</label>
                        <div class="col-md-10">
                          <input class="form-control" type="text" name="email" readonly
                            value="{{ $user['email'] }}">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-2 col-form-label">NIK (Nomor Induk Kependudukan)*</label>
                        <div class="col-md-10">
                          <input class="form-control" required type="number" name="nik" maxlength="16"
                            placeholder="NIK (Nomor Induk Kependudukan) harus merupakan angka dan 16 karakter"
                            value="{{ $user['nik'] }}">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-2 col-form-label">NIDN/NIDK*</label>
                        <div class="col-md-10">
                          <input class="form-control" required type="number" name="nidn_nidk" maxlength="10"
                            placeholder="NIDN/NIDK harus merupakan angka dan 10 karakter"
                            value="{{ $user['nidn_nidk'] }}">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-2 col-form-label">Gelar Sebelum Nama</label>
                        <div class="col-md-10">
                          <input class="form-control" type="text" name="gelar_depan"
                            placeholder="Gelar Depan adalah gelar depan peserta. Pastikan gelar anda dieja dengan benar."
                            value="{{ $user['gelar_depan'] }}">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-2 col-form-label">Nama Lengkap*</label>
                        <div class="col-md-10">
                          <input class="form-control" required type="text" name="fullname"
                            placeholder="Nama Lengkap adalah nama lengkap peserta, diawali dengan huruf kapital pada setiap awal kata"
                            value="{{ $user['fullname'] }}">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-2 col-form-label">Gelar Setelah Nama</label>
                        <div class="col-md-10">
                          <input class="form-control" type="text" name="gelar_belakang"
                            placeholder="Gelar Belakang adalah gelar belakang peserta. Pastikan gelar anda dieja dengan benar."
                            value="{{ $user['gelar_belakang'] }}">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-2 col-form-label">Nama Instansi*</label>
                        <div class="col-md-10">
                          <input class="form-control" required type="text" name="nama_instansi"
                            placeholder="Nama instansi adalah nama perguruan tinggi calon peserta berasal"
                            value="{{ $user['nama_instansi'] }}">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-2 col-form-label">Jenis Kelamin*</label>
                        <div class="col-md-10">
                          <select name="jenis_kelamin" class="form-control" required>
                            @if ($user['jenis_kelamin'] == null)
                              <option selected>Pilih Jenis Kelamin</option>
                              <option value="Laki-laki">Laki-laki</option>
                              <option value="Perempuan">Perempuan</option>
                            @elseif ($user['jenis_kelamin'] == 'Laki-laki')
                              <option>Pilih Jenis Kelamin</option>
                              <option value="Laki-laki" selected>Laki-laki</option>
                              <option value="Perempuan">Perempuan</option>
                            @else
                              <option>Pilih Jenis Kelamin</option>
                              <option value="Laki-laki">Laki-laki</option>
                              <option value="Perempuan" selected>Perempuan</option>
                            @endif
                          </select>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-2 col-form-label">Tempat Lahir*</label>
                        <div class="col-md-10">
                          <input class="form-control" required type="text" name="tempat_lahir"
                            placeholder="Tempat Lahir adalah nama kota tempat peserta dilahirkan"
                            value="{{ $user['tempat_lahir'] }}">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-2 col-form-label">Tanggal Lahir*</label>
                        <div class="col-md-10">
                          <input class="form-control" required type="date" name="tanggal_lahir"
                            placeholder="Gelar Belakang adalah gelar belakang peserta. Pastikan gelar anda dieja dengan benar."
                            value="{{ $user['tanggal_lahir'] }}">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-2 col-form-label">Alamat*</label>
                        <div class="col-md-10">
                          <textarea class="form-control" name="alamat" rows="3" maxlength="225"
                            placeholder="Alamat adalah alamat lengkap tempat tinggal peserta">{{ $user['alamat'] }}</textarea>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-2 col-form-label">Provinsi*</label>
                        <div class="col-md-10">
                          <input class="form-control" required type="text" name="provinsi"
                            placeholder="Provinsi adalah provinsi dari alamat tempat tinggal peserta"
                            value="{{ $user['provinsi'] }}">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-2 col-form-label">Kota*</label>
                        <div class="col-md-10">
                          <input class="form-control" required type="text" name="kota"
                            placeholder="Kota adalah kota dari alamat tempat tinggal peserta"
                            value="{{ $user['kota'] }}">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-2 col-form-label">Kode Pos*</label>
                        <div class="col-md-10">
                          <input class="form-control" required type="text" name="kode_pos"
                            placeholder="Kode Pos adalah kode pos dari alamat tempat tinggal peserta"
                            value="{{ $user['kode_pos'] }}">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-2 col-form-label">Telepon*</label>
                        <div class="col-md-10">
                          <input class="form-control" required type="number" name="telepon" maxlength="13"
                            placeholder="Telepon adalah Nomor Telepon peserta yang dapat dihubungi"
                            value="{{ $user['telepon'] }}">
                        </div>
                      </div>
                      
                      <h4 class="header-title mt-5">Berkas Peserta</h4>

                      @if ($user['berkas_ktp'])
                        <label class="col-md-2 col-form-label"><a href="{{ '/files/ktp/' . $user['berkas_ktp'] }}">Lihat Berkas KTP</a></label>
                      @endif
                      <div class="form-group row">
                        <label class="col-md-2 col-form-label">Berkas Kartu Tanda Penduduk*</label>
                        <div class="custom-file col-md">
                          <label class="custom-file-label">Pilih Berkas KTP</label>
                          <input type="file" name="ktp" class="custom-file-input" accept="application/pdf" @if ($user['berkas_ktp'] == null) required @endif>
                        </div>
                      </div>
                      
                      @if ($user['berkas_sk_dosen'])
                        <label class="col-md col-form-label"><a href="{{ '/files/sk-dosen/' . $user['berkas_sk_dosen'] }}">Lihat Berkas SK Dosen</a></label>
                      @endif
                      <div class="form-group row">
                        <label class="col-md-2 col-form-label">Berkas SK Dosen*</label>
                        <div class="custom-file col-md">
                          <label class="custom-file-label">Pilih Berkas SK Dosen</label>
                          <input type="file" name="sk_dosen" class="custom-file-input" accept="application/pdf" @if ($user['berkas_sk_dosen'] == null) required @endif>
                        </div>
                      </div>
                      
                      @if ($user['berkas_sk_pekerti'])
                        <label class="col-md col-form-label"><a href="{{ '/files/sk-pekerti/' . $user['berkas_sk_pekerti'] }}">Lihat Berkas SK PEKERTI</a></label>
                      @endif
                      <div class="form-group row">
                        <label class="col-md-2 col-form-label">Berkas SK PEKERTI</label>
                        <div class="custom-file col-md">
                          <label class="custom-file-label">Pilih Berkas SK PEKERTI</label>
                          <input type="file" name="sk_pekerti" class="custom-file-input" accept="application/pdf" @if ($user['berkas_sk_pekerti'] == null && $pelatihan['jenis_pelatihan'] == "aa") required @endif>
                        </div>
                      </div>

                      <h4 class="header-title mt-5">Foto Profil</h4>

                      <img src="{{ $user['foto_profil'] == null ? '/images/default.jpg' : '/images/foto-profil/' . $user['foto_profil']; }}" style="max-width:100%;height:auto" width="177" height="236">

                      <div class="form-group row mt-3">
                        <label class="col-md-2 col-form-label">Berkas Foto Profil*</label>
                        <div class="custom-file col-md">
                          <label class="custom-file-label col-md-12">Pilih Berkas Foto Profil</label>
                          <input type="file" name="foto_profil" class="custom-file-input" accept="image/png, image/jpg, image/jpeg" @if ($user['foto_profil'] == null) required @endif>
                        </div>
                      </div>

                      <button class="btn btn-primary btn-block waves-effect waves-light w-25"
                        type="submit">Daftar Pelatihan</button>

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
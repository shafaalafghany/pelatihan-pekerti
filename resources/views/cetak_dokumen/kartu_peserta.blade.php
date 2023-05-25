<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Cetak Kartu Peserta | Pelatihan PEKERTI-AA</title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <div class="printme row justify-content-center">
      <div class="col-auto">
        <table class="table table-bordered" style="width: 100%;">
          <tr>
            <td colspan="4" class="text-center"><h1 class="font-weight-bold">PEKERTI-AA UB<br>KARTU TANDA PESERTA</h1></td>
          </tr>
          <tr>
            <td rowspan="4" colspan="2"><img src="/images/foto-profil/{{ $data->foto_profil }}" class="img-responsive col-md-10"></td>
            <td><h4 class="font-weight-bold">Nama&emsp;&emsp;&emsp;&emsp;&nbsp;:</h4></td>
            <td><h4>{{ $data->fullname }}</h4></td>
          </tr>
          <tr>
            <td><h4 class="font-weight-bold">Asal Institusi&emsp;:</h4></td>
            <td><h4>{{ $data->nama_instansi }}</h4></td>
          </tr>
          <tr>
            <td><h4 class="font-weight-bold">Pelatihan&emsp;&emsp;&ensp;&nbsp;:</h4></td>
            <td><h4>{{ $data->nama }}</h4></td>
          </tr>
          <tr>
            <td><h4 class="font-weight-bold">Tahun&emsp;&emsp;&emsp;&emsp;&nbsp;:</h4></td>
            <td><h4>{{ \Carbon\Carbon::now()->format("Y") }}</h4></td>
          </tr>
          <tr>
            <td colspan="4" class="text-center"><h4>MOHON KARTU PESERTA DIBAWA<br>PADA SAAT PELATIHAN</h4></td>
          </tr>
        </table>
      </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

    <script src="https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js"></script>

    <script src="{{ asset('assets/js/pages/dashboard.init.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script>
      window.onload = function() {
        window.print();
      }
    </script>
  </body>
</html>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cetak Invoice | Pelatihan PEKERTI-AA</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
      img.bg {
        position:absolute;
        z-index:0;
        opacity: 0.1;
        background-position: center;
        width: 80%;
      }
    </style>
  </head>
  <body>
    <div class="printme row justify-content-center">
      <div class="col-auto">
        <img class="bg" src="/images/lunas.png">
        <table class="table table-borderless" style="width: 100%;">
          <tr>
            <td rowspan="2" colspan="3"><img src="/images/logo.jpg" width="175"></td>
            <td><strong>INVOICE</strong></td>
          </tr>
          <tr>
            <td>{{ $data['invoice'] }}</td>
          </tr>
          <tr>
            <td colspan="3"><strong>DITERBITKAN OLEH</strong></td>
            <td><strong>UNTUK</strong></td>
          </tr>
          <tr>
            <td rowspan="2" colspan="3">Nama  : <strong>PEKERTI-AA UB</strong></td>
            <td>Peserta : <strong>{{ strtoupper($data['fullname']) }}</strong></td>
          </tr>
          <tr>
            <td>Tanggal Pembayaran : <strong>{{ strtoupper(\Carbon\Carbon::parse($data['updated_at'])->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('j F Y')) }}</strong></td>
          </tr>
          <tr>
            <td colspan="4"><hr></td>
          </tr>
          <tr>
            <td colspan="3"><strong>INFO BARANG</strong></td>
            <td><strong>TOTAL HARGA</strong></td>
          </tr>
          <tr>
            <td colspan="4"><hr></td>
          </tr>
          <tr>
            <td colspan="3"><strong>{{ $data['nama'] }}</strong></td>
            <td>Rp200.000</td>
          </tr>
          <tr>
            <td colspan="2"></td>
            <td><strong>TOTAL TAGIHAN</strong></td>
            <td><strong><b>Rp200.000</b></strong></td>
          </tr>
          <tr>
            <td colspan="4"><hr></td>
          </tr>
          <tr>
            <td colspan="3">Invoice ini sah dan diproses oleh komputer<br>Silakan hubungi Admin apabila kamu membutuhkan bantuan.</td>
            <td><i>Terakhir diupdate: {{ \Carbon\Carbon::parse($data['updated_at'])->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('j F Y h:i') }}</i></td>
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
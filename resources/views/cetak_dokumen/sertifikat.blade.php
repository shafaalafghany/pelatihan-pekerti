<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Cetak Sertifikat | Pelatihan PEKERTI-AA</title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        @media print{@page {
            size: landscape;
        }}
    </style>
</head>

<body>
    <div class="row justify-content-center">
        <div class="col-7">
            <table class="table table-borderless">
                <tr>
                    <td class="d-flex align-self-center col-1"><img src="{{ asset('/images/kemdikbud.png') }}"
                            class="img-responsive" width="100" height="100"></td>
                    <td class="col-10 text-center">
                        <h4><b>KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</b></h4>
                        <h3><b>UNIVERSITAS BRAWIJAYA</b></h3>
                        <h4><b>PUSAT PENGEMBANGAN AKTIFITAS DAN TEKNOLOGI PEMBELAJARAN (P2ATP)</b></h4>
                        <h6>Gedung Layanan Bersama Lt. X Jl. Veteran, Malang 65145, Indonesia</h6>
                        <h6>Telp: +62-341-575826, Fax: +62-341-559701, https://p2atp.ub.ac.id, e-mail: p2atp@ub.ac.id
                        </h6>
                    </td>
                    <td class="d-flex align-self-center col-1"><img src="{{ asset('/images/ub.png') }}"
                            class="img-responsive" width="100" height="100"></td>
                </tr>
                <tr>
                    <td class="py-0" colspan="3">
                        <hr class="my-0" style="border: none; height: 3px; background-color: black; color: black;">
                    </td>
                </tr>
                <tr>
                    <td class="text-center" colspan="3">
                        <h1><em><b>SERTIFIKAT</b></em></h1>
                        Nomor: {{ $data->nomor_sertifikat }}
                    </td>
                </tr>
                <tr>
                    <td class="text-center" colspan="3">
                        <h4><b>Pusat Pengembangan Aktifitas dan Teknologi Pembelajaran (P2ATP) Universitas Brawijaya</b>
                        </h4>

                    </td>
                </tr>
                <tr>
                    <td class="text-center" colspan="3">
                        <h6><em>Menyatakan</em></h6>
                    </td>
                </tr>
                <tr>
                    <td class="text-center" colspan="3">
                        <h3><b>{{ $data->gelar_depan ? $data->gelar_depan : '' }} {{ $data->fullname }},
                                {{ $data->gelar_belakang ? $data->gelar_belakang : '' }}</b></h3>
                    </td>
                </tr>
                <tr>
                    <td class="text-center" colspan="3">
                        @if ($data->jenis_pelatihan == 'pekerti')
                            <h4><b>Lulus Pada Pelatihan Pengembangan Keterampilan Dasar Teknik Instruksional</b></h4>
                            <h4><b>(PEKERTI) Angkatan V Tahun
                                    {{ \Carbon\Carbon::parse($data->created_at)->format('Y') }}</b></h4>
                        @else
                            <h4><b>Lulus Pada Applied Approach (AA)</b></h4>
                            <h4><b>Angkatan V Tahun {{ \Carbon\Carbon::parse($data->created_at)->format('Y') }}</b>
                            </h4>
                        @endif
                        <h4><b>Dilaksanakan Pada Tanggal {{ $data->pelaksanaan }}</b></h4>
                    </td>
                </tr>
                <tr>
                    <td class="" colspan="3">
                        <div class="d-flex w-auto">
                            <div class="container w-auto d-flex">
                                <div class="row">
                                    <div class="col-sm w-auto p-0 text-right">
                                        <img class=""
                                            src="{{ asset('/images/foto-profil/' . $data->foto_profil) }}"
                                            width="125" height="175">
                                    </div>
                                    <div class="d-flex flex-column justify-content-between col-sm w-auto pr-0 pl-1">
                                        <div>
                                            <b>Malang,
                                                {{ \Carbon\Carbon::parse($data->created_at)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('j F Y') }}</b><br>
                                            <b>Ketua P2ATP,</b><br>
                                        </div>
                                        <div class="w-auto" style="min-width: max-content;">
                                            <b>Ir. Ishardita Pambudi Tama, ST., MT., Ph.D.</b><br>
                                            <b>NIP 197308191999031002</b><br>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </td>
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
    {{-- <script>
        window.onload = function() {
            var css = '@page { size: landscape; }',
                head = document.head || document.getElementsByTagName('head')[0],
                style = document.createElement('style');

            style.type = 'text/css';
            style.media = 'print';

            if (style.styleSheet) {
                style.styleSheet.cssText = css;
            } else {
                style.appendChild(document.createTextNode(css));
            }

            head.appendChild(style);

            window.print();
        }
    </script> --}}
</body>

</html>

<!doctype html>
{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> --}}

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $data->name }}</title>
    <!-- Fonts -->

    <!-- Styles -->
    <!-- Font Awesome -->
    {{-- <link rel="stylesheet" href="{{ asset('bootsrap/css/bootstrap/bootstrap.css') }}" type="text/css"> --}}


</head>

<body>
    <style type="text/css">
        @page {
            margin: 0px;
        }

        /* * { padding: 0; margin: 0; } */
        @font-face {
            font-family: "source_sans_proregular";
            src: local("Source Sans Pro"), url("fonts/sourcesans/sourcesanspro-regular-webfont.ttf") format("truetype");
            font-weight: normal;
            font-style: normal;

        }

        body {
            font-family: "source_sans_proregular", Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;
        }
    </style>

    <style>
        .container {
            margin-left: 80px;
            margin-right: 80px;
        }

        .normalfontsize {
            font-size: 0.9rem
        }

        .tablefontsize {
            font-size: 0.75rem
        }

        .w-100 {
            width: 100%;
        }

        .margin-normal {
            margin-top: 0 !important;
            margin-bottom: 0;
            padding-bottom: 5px !important;
        }

        .text-bold {
            font-weight: bold;
        }

        .text-center {
            text-align: center !important;
        }

        .text-left {
            text-align: left !important;
        }

        .bg-blue {
            background-color: rgb(43, 102, 168);
            color: white;
        }

        .mx-1 {
            margin-right: 10px;
            margin-left: 10px;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        td {
            padding: 5;
        }


        .px-1 {
            padding-right: 10px;
            padding-left: 10px;
        }

        .wo-border {
            border: none;
            padding-top: 0 !important;
        }

        .dot {
            width: 10px;
            height: 10px;
            background-color: black;
            border-radius: 50px;
            display: inline-block;
            margin-right: 10px
        }

        ul {
            margin-top: 0 !important;
        }

        .page-break {
            page-break-after: always;
        }
    </style>

    <br>

    <div>
        {{-- <img src="{{ public_path('static-image/logo.png') }}" style="width: 120px; float: left;" /> --}}

        <div>
            <div style=" text-align: center;margin-bottom:5px ;margin-top:0">
                <img style="width: 130px" src="https://internal.yousee-indonesia.com/images/local/yousee.png" />
            </div>
            {{--            @if (request('start')) --}}
            {{--                <h5 style=" text-align: center;margin-bottom:10px ;margin-top:0">Periode --}}
            {{--                    {{ date_format(DateTime::createFromFormat('Y-m-d', request('start')), 'd M Y') }} s/d --}}
            {{--                    {{ date_format(DateTime::createFromFormat('Y-m-d', request('end')), 'd M Y') }}</h5> --}}
            {{--            @endif --}}

        </div>

        <br>

        <div class="container normalfontsize">
            <p style="float: right" class="margin-normal">Sukoharjo, {{ $date }}</p>
            <table class="wo-border">
                <tr>
                    <td class="wo-border ">No</td>
                    <td class="wo-border">:</td>
                    <td class="wo-border">{{ $data->number_doc }}</td>
                </tr>
                <tr>
                    <td class="wo-border">Hal</td>
                    <td class="wo-border">:</td>
                    <td class="wo-border">Penawaran</td>
                </tr>
                <tr class="text-bold">
                    <td class="wo-border">Lamp</td>
                    <td class="wo-border">:</td>
                    <td class="wo-border">Price List & Foto Denah Lokasi</td>
                </tr>
            </table>

            <br>

            <p class="margin-normal">Kepada:</p>
            <p class="margin-normal text-bold">{{ $data->to_name }}</p>
            <p class="margin-normal">Di. Tempat.</p>

            <br>
            <p class="margin-normal text-bold">Dengan Hormat,</p>
            <p class="margin-normal">Bersama surat ini, kami <span class="text-bold">YOUSEE INDONESIA</span> mengajukan
                <span class="text-bold">Penawaran Harga {{ $data->name }}, </span>Adapun penawaran kami sebagai
                berikut :
            </p>


        </div>

        <br>

        {{-- TABLE --}}
        <div style="position: relative; " class="mx-1">
            <table class="tablefontsize w-100">
                <thead class="bg-blue">
                    <tr>
                        <th rowspan="2" class="text-center ">No</th>
                        <th rowspan="2">Kota/Kab</th>
                        <th rowspan="2" style="width: 250px">Alamat Lokasi</th>
                        <th colspan="3">Ukuran</th>
                        <th rowspan="2">V/H</th>
                        <th rowspan="2">Status</th>
                        {{--                        @if ($data->total_price == 0) --}}
                        <th rowspan="2">{{ $data->duration }} {{ $data->duration_unit }}</th>
                        {{--                        @endif --}}
                    </tr>
                    <tr>
                        <th>P</th>
                        <th>X</th>
                        <th>L</th>
                    </tr>

                </thead>
                <tbody>
                    <?php $sum_tot_Price = 0; ?>
                    @forelse($item as $key => $d)
                        <tr>
                            <td class="text-center " style="width: 50px">{{ $key + 1 }}</td>
                            <td class="text-center ">{{ $d->city->name }}</td>
                            <td>{{ $d->item->address }}<br>{{ $d->item->location }}</td>
                            <td class="text-center ">{{ $d->item->width }}</td>
                            <td class="text-center ">x</td>
                            <td class="text-center ">{{ $d->item->height }}</td>
                            <td class="text-center ">{{ $d->item->position }}</td>
                            <td class="text-center ">
                                {{ $d->available == 'Tersedia' ? $d->available : 'Tersedia tgl ' . $d->available }}
                            </td>
                            @if ($data->total_price == 0)
                                <td class="text-center ">Rp. {{ number_format($d->end_price) }}</td>
                            @else
                                @if ($key == 0)
                                    <td class="text-center " rowspan="{{ count($data->items) }}">Rp.
                                        {{ number_format($data->total_price) }}</td>
                                @endif
                            @endif
                        </tr>
                        <?php $sum_tot_Price += $d->end_price; ?>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                    {{--                    <tr> --}}
                    {{--                        <td>1</td> --}}
                    {{--                        <td class="text-center ">Bekasi</td> --}}
                    {{--                        <td>Jl KH Noer Ali, Kota Bekasi, Jawa Barat (Jakarta/Kota Menuju Galaxy/A Yani) </td> --}}
                    {{--                        <td class="text-center ">4</td> --}}
                    {{--                        <td class="text-center ">x</td> --}}
                    {{--                        <td class="text-center ">6</td> --}}
                    {{--                        <td class="text-center ">Vertikal</td> --}}
                    {{--                        <td class="text-center ">Rp 30.000.000</td> --}}
                    {{--                        <td class="text-center ">Rp 90.000.000</td> --}}
                    {{--                    </tr> --}}
                </tbody>
                {{--                @if ($data->total_price == 0) --}}
                <tfoot>
                    <tr>
                        <td colspan="8" class="text-center text-bold">Total Harga</td>
                        <td class="text-center text-bold">Rp.
                            {{ $data->total_price == 0 ? number_format($sum_tot_Price) : number_format($data->total_price) }}
                        </td>
                    </tr>
                </tfoot>
                {{--                @endif --}}
            </table>
        </div>

        <div class="container">
            <br>
            <div class="normalfontsize">
                <p class="margin-normal  text-bold">Ketarangan :</p>
                {!! $data->description !!}
                {{--                <p class="margin-normal"><span class="dot"></span> Perawatan selama kontrak (kerusakan media,dsb) --}}
                {{--                </p> --}}
                {{--                <p class="margin-normal"><span class="dot"></span> Sudah termasuk cetak & pasang visual 1x </p> --}}
            </div>
            <br>
            <p class="margin-normal normalfontsize ">Demikian penawaran kami, atas perhatian dan kerjasamanya kami
                mengucapkan terimakasih.</p>

            <br>
            <p class="margin-normal normalfontsize ">Hormat Kami,</p>
            <br><br><br>
            <p class="margin-normal normalfontsize text-bold">{{ $data->from }}</p>
        </div>

        <br>

        <div style="position:absolute; bottom: 0; z-index: -10;">
            <img style="width: 100%" src="https://internal.yousee-indonesia.com/images/local/footerreport.jpg" />
        </div>


        <div class="page-break"></div>

        {{-- HEADER --}}
        @foreach ($item as $i)
            @if (!isset($prevItem) || $i->city->id !== $prevItem)
                <img style="width: 100%;position:absolute; bottom: 0; z-index: -10;"
                    src="https://internal.yousee-indonesia.com/images/local/headertiapkota.jpg" />
                <h1
                    style="position:absolute; top: 280px; z-index: 10; text-align: center; width: 100%; font-size: 3em; font-weight: bold">
                    {{ $i->city->name }}
                </h1>
                <div class="page-break"></div>

                @foreach ($item as $it)
                    @if ($i->city->id == $it->city->id)
                        @if ($it->item->image2 != null)
                            <div>
                                <a
                                    style="bottom: 30px; left: 30px; width: 30px; height: 30px; font-size: 1.5rem; position:absolute; border-radius: 50%; color: black; background-color: white; padding: 5px; font-weight: bold; text-align: center; line-height: 30px">{{ $it->index_number + 1 }}</a>
                                <img style="width: 100%;position:absolute; bottom: 0; z-index: -10;"
                                    src="https://internal.yousee-indonesia.com/{{ $it->item->image2 }}" />
                                {{-- src="http://yousee.test/{{ $it->item->image2 }}" /> --}}
                                <div class="page-break"></div>

                            </div>
                        @endif
                    @endif
                @endforeach
            @endif
            @php $prevItem = $i->city->id @endphp
        @endforeach
        <div>

        </div>




        {{-- SERVICE AREA --}}
        <div>
            <img style="width: 100%;position:absolute; bottom: 0; z-index: -10;"
                src="https://internal.yousee-indonesia.com/images/local/servicearea.jpg" />

        </div>
    </div>


    <!-- JS -->
    <script src="js/app.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>

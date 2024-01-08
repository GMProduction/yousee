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

        {{-- HEADER --}}
        @foreach ($item as $i)
            @if (!isset($prevItem) || $i->city->id !== $prevItem)
                <img style="width: 100%;position:absolute; bottom: 0; z-index: -10;"
                    src="https://internal.yousee-indonesia.com/images/local/headertiapkotatanpalogo.jpg" />
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

    </div>


    <!-- JS -->
    <script src="js/app.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>

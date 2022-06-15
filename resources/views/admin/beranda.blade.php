@extends('admin.base')

@section('css')

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
          integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
          crossorigin=""/>

    <style>
        .select2-selection__rendered {
            line-height: 36px !important;
        }

        .select2-container .select2-selection--single {
            height: 36px !important;
            border: 1px solid #ddd;
        }

        .select2-selection__arrow {
            height: 36px !important;
        }
    </style>
@endsection
@section('content')
    <div class="panel">
        <div class="title">
            <p>Portfolio</p>
        </div>

        <div class="isi">
            <div class="row" id="cardType">
            </div>

        </div>

        <div class="panel">
            <div class="title">
                <p>Titik yang baru dimasukan</p>
                <a class="btn-utama-soft sml rnd " id="addData">Titik Baru <i
                        class="material-icons menu-icon ms-2">add_circle</i></a>
            </div>

            @include('admin.item-table')


        </div>

        <!-- Modal -->
        @include('admin.item-modal')

    </div>
@endsection

@section('morejs')
    <script src="{{ asset('js/number_formater.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
            integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
            crossorigin=""></script>

    {{-- @include('admin.map', ['data' => 'script']) --}}

    <script src="{{ asset('js/map-control.js') }}"></script>
    <script src="{{ asset('js/item.js') }}"></script>
    <script>
        $(document).ready(function() {
            onTabChange();
            getCard();
            datatableItem();
            getSelect('type', window.location.pathname + '/item/type')
            setImgDropify('image1');
            setImgDropify('image2');
            setImgDropify('image3');
            saveItem();
            $('#province').select2({
                dropdownParent: $("#modaltambahtitik")
            });
            $('#city').select2({
                dropdownParent: $("#modaltambahtitik")
            });
            $('#vendor').select2({
                dropdownParent: $("#modaltambahtitik")
            });
        });



        function getCard() {
            $.get('/admin/item/card', function(data, status, response) {
                let card = $('#cardType');
                card.empty;
                if (response.status === 200) {
                    $.each(data, function(k, v) {
                        let img = v.icon;
                        card.append('<div class="col-4 my-2 ">\n' +
                            '                        <div class="panel-peformace p-2 rounded shadow">\n' +
                            '                            <img src="' + img + '"/>\n' +
                            '                            <div class="content">\n' +
                            '                                <p class="nama">' + v.name + '</p>\n' +
                            '                                <p class="nilai">' + v.count +
                            ' Titik</p>\n' +
                            '                            </div>\n' +
                            '                        </div>\n' +
                            '                    </div>')
                    })
                }
            })
        }


    </script>
@endsection

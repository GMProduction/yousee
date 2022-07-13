@extends('pimpinan.base')
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

        /*.leaflet-container {*/
        /*    height: 400px;*/
        /*    width: 600px;*/
        /*    max-width: 100%;*/
        /*    max-height: 100%;*/
        /*}*/
        #map {
            height: 500px;
            width: 100%
        }

        #main-map {
            height: 500px;
            width: 100%
        }

        #single-map-container {
            height: 450px;
            width: 50%
        }

        .marker-position {
            top: -25px;
            left: 0;
            position: relative;
            color: aqua;
            font-weight: bold;
        }

    </style>
    <script src="{{ asset('js/map-control.js') }}"></script>
@endsection
@section('content')
    <div class="d-flex justify-content-start align-items-center">
        <div class="me-3">
            <a class="btn-utama sml rnd flex" href="#" role="button" id="dropdownprofile" data-bs-toggle="dropdown"
               style="padding-top: 5px; padding-bottom: 5px; border-radius: 10px">Filter
                <i class="material-icons menu-icon ms-2 ">filter_list</i></a>
            <ul id="dropSearch" class="dropdown-menu custom" aria-labelledby="dropdownprofile">
                <div class="filter-panel">
                    <div class="form-group">
                        <label for="f-provinsi" class="form-label">Provinsi</label>
                        <select class="form-select mb-3" aria-label="Default select example" id="f-provinsi"
                                name="f-provinsi">

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="f-kota" class="form-label">Kota</label>
                        <select class="form-select mb-3" aria-label="Default select example" id="f-kota"
                                name="f-kota">
                            <option selected value="">Semua Kota</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="f-tipe" class="form-label">Tipe</label>
                        <select class="form-select mb-3" aria-label="Default select example" id="f-tipe"
                                name="f-tipe">
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="f-posisi" class="form-label">Psisi</label>
                        <select class="form-select mb-3" aria-label="Default select example" id="f-posisi"
                                name="f-posisi">
                            <option selected value="">Semua Posisi</option>
                            <option value="Horizontal">Horizontal</option>
                            <option value="Vertical">Vertical</option>
                        </select>
                    </div>

                </div>
            </ul>
        </div>
        <div class="mb-2" id="pillSearch">
        </div>
    </div>
    <div class="mt-2">
        <div id="main-map" style="width: 100%; height: 500px"></div>
    </div>
    @include('admin.item-modal')
@endsection

@section('morejs')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1MgLuZuyqR_OGY3ob3M52N46TDBRI_9k&callback=initMap&v=weekly"
        async
    ></script>
    <script src="{{ asset('js/number_formater.js') }}"></script>
    <script src="{{ asset('js/item.js') }}"></script>
    <script>
        $(document).ready(function () {
            getSelect('f-provinsi', '/pimpinan/province', 'name', null, 'Semua Provinsi');
            getSelect('type', window.location.pathname + '/type')
            getSelect('f-tipe', window.location.pathname + '/type', 'name', null, 'Semua Type');
            getSelect('f-kota', '/pimpinan/city', 'name', null, 'Semua Kota');
            generateGoogleMapData().then(r => {})
        });
    </script>
@endsection

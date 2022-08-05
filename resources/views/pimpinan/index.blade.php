@extends('pimpinan.base')
@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />

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
    <script src="{{ asset('js/map-control.js?v=2') }}"></script>
@endsection
@section('content')
    <div class="">
        <div class="d-flex justify-content-start align-items-center">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link genostab active" id="pills-peta-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-peta" type="button" role="tab" aria-controls="pills-peta"
                        aria-selected="false">View Maps
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link genostab " id="pills-tabel-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-tabel" type="button" role="tab" aria-controls="pills-tabel"
                        aria-selected="true">View List
                    </button>
                </li>


            </ul>

            <div class="ms-auto">
                <a class="btn-utama sml rnd flex" href="#" role="button" id="dropdownprofile"
                    data-bs-toggle="dropdown" style="padding-top: 5px; padding-bottom: 5px; border-radius: 10px">Filter
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
                            <label for="f-posisi" class="form-label">Posisi</label>
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

        </div>
        <div class="mb-2" id="pillSearch">
        </div>
        <div class="mt-2">
            <div class="tab-content">
                <div class="tab-pane fade " id="pills-tabel" role="tabpanel" aria-labelledby="pills-tabel-tab">
                    <div class="panel">
                        @include('admin.item-table',['tabel' => 'presence'])

                    </div>

                </div>
                <div class="tab-pane fade show active" id="pills-peta" role="tabpanel" aria-labelledby="pills-peta-tab">
                    {{-- @include('admin.map', ['data' => 'content']) --}}
                    <div id="main-map" style="width: 100%; height: 500px; height: calc(100vh - 200px)"></div>
                </div>
            </div>
            {{-- <div id="main-map" style="width: 100%; height: calc(100vh - 200px)"></div> --}}

        </div>
    </div>
    @include('admin.item-modal')
@endsection

@section('morejs')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1MgLuZuyqR_OGY3ob3M52N46TDBRI_9k&callback=initMap&v=weekly"
        async></script>
    <script src="{{ asset('js/number_formater.js') }}"></script>
    <script src="{{ asset('js/item.js?v=3') }}"></script>
    <script>
        $(document).ready(function() {
            getSelect('f-provinsi', '/data/province', 'name', null, 'Semua Provinsi');
            getSelect('type', '/data/type')
            getSelect('f-tipe', '/data/type', 'name', null, 'Semua Type');
            getSelect('f-kota', '/data/city', 'name', null, 'Semua Kota');
            generateGoogleMapData().then(r => {})
            datatableItemPresence();
        });
    </script>
@endsection

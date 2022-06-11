@extends('admin.base')
@section('css')
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
    <div>

        <div class="d-flex justify-content-between">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link genostab active" id="pills-tabel-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-tabel" type="button" role="tab" aria-controls="pills-tabel"
                            aria-selected="true">Tabel
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link genostab" id="pills-peta-tab" data-bs-toggle="pill" data-bs-target="#pills-peta"
                            type="button" role="tab" aria-controls="pills-peta" aria-selected="false">Maps
                    </button>
                </li>

            </ul>


            <div>
                <a class="btn-utama sml rnd " href="#" role="button" id="dropdownprofile" data-bs-toggle="dropdown">Filter <i
                        class="material-icons menu-icon ms-2 ">filter_list</i></a>
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
                            <select class="form-select mb-3" aria-label="Default select example" id="f-kota" name="f-kota">
                                <option selected value="">Semua Kota</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="f-tipe" class="form-label">Tipe</label>
                            <select class="form-select mb-3" aria-label="Default select example" id="f-tipe" name="f-tipe">
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
        </div>
        <div class="mb-2" id="pillSearch">
            {{--             <span id="pillProvince" class="badge bg-primary " style="border-radius: 200px; align-items: center"><span id="text" class="text">asdasd</span>  <a role="button"><i class="material-icons" style="font-size: 12px">close</i></a></span>--}}

        </div>

        <div class="panel">
            <div class="title">
                <p>Titik yang baru dimasukan</p>
                <a class="btn-utama-soft sml rnd " id="addData">Titik Baru <i
                        class="material-icons menu-icon ms-2">add_circle</i></a>
            </div>

            <div class="isi">
                <div class="table">
                    <table id="table_id" class="table table-striped" style="width:100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Area</th>
                            <th>Kode</th>
                            <th>Alamat</th>
                            <th>Panjang / Tinggi</th>
                            <th>Lebar</th>
                            <th>Type</th>
                            <th>Posisi</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Area</th>
                            <th>Kode</th>
                            <th>Alamat</th>
                            <th>Panjang / Tinggi</th>
                            <th>Lebar</th>
                            <th>Type</th>
                            <th>Posisi</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>

        <!-- Modal -->
        <div class="modal fade" id="modaltambahtitik" tabindex="-1" aria-labelledby="modaltambahtitik"
             aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modaltambahuser">Tambah Titik Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form" enctype="multipart/form-data">
                            @csrf
                            <input id="id" name="id" hidden>
                            <div class="row mb-3">
                                <div class="col-md-4 col-sm-12">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nama">

                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="province" class="form-label">Provinsi</label>
                                    <select class="form-select mb-3 w-full" style="width: 100%" id="province">
                                    </select>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="city" class="form-label">Kota</label>
                                    <select class="form-select mb-3" style="width: 100%" id="city" name="city_id">
                                        <option>Pilih Data</option>
                                    </select>
                                </div>

                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="address" name="address" placeholder="Alamat">
                                <label for="alamat" class="form-label">Alamat</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="location" name="location" placeholder="Lokasi">
                                <label for="location" class="form-label">Lokasi</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="urlstreetview" name="url"
                                       placeholder="urlstreetview">
                                <label for="urlstreetview" class="form-label">URL Street View</label>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="latitude" name="latitude"
                                               placeholder="latitude">
                                        <label for="latitude" class="form-label">Latitude</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="longitude" name="longitude"
                                               placeholder="0">
                                        <label for="longitude" class="form-label">Longitude</label>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <label for="type" class="form-label">Tipe</label>
                                    <select class="form-select mb-3" aria-label="Default select example" id="type" name="type_id">
                                    </select>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <label for="position" class="form-label">Posisi</label>
                                    <select class="form-select mb-3" aria-label="Default select example" id="position"
                                            name="position">
                                        <option selected>Pilih Posisi</option>
                                        <option value="Horizontal">Horizontal</option>
                                        <option value="Vertical">Vertical</option>
                                    </select>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="height" type="number" name="height"
                                               placeholder="0">
                                        <label for="height" class="form-label">Panjang/Tinggi</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="width" name="width" placeholder="lebar">
                                        <label for="width" class="form-label">Lebar</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <div class="mb-3">
                                        <label for="gambar1" class="form-label">Gambar 1</label>
                                        <input type="file" id="image1" name="" class="image" data-min-height="10"
                                               data-heigh="400" accept="image/jpeg, image/jpg, image/png"
                                               data-allowed-file-extensions="jpg jpeg png"/>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <div class="mb-3">
                                        <label for="gambar2" class="form-label">Gambar 2</label>
                                        <input type="file" id="image2" name="" class="image" data-min-height="10"
                                               data-heigh="400" accept="image/jpeg, image/jpg, image/png"
                                               data-allowed-file-extensions="jpg jpeg png"/>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <div class="mb-3">
                                        <label for="gambar3" class="form-label">Gambar 3</label>
                                        <input type="file" id="image3" name="" class="image" data-min-height="10"
                                               data-heigh="400" accept="image/jpeg, image/jpg, image/png"
                                               data-allowed-file-extensions="jpg jpeg png"/>
                                    </div>
                                </div>
                            </div>
                            <div class="my-3">
                                <div class="d-flex">
                                    <button type="submit" class="btn-utama" style="width: 100%">Simpan</button>
                                </div>

                            </div>
                        </form>


                    </div>


                </div>
            </div>
        </div>


        <!-- Modal Detail-->
        <div class="modal fade" id="modaldetail" tabindex="-1" aria-labelledby="modaldetail" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Titik ( <span id="d-name"></span> )</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link genostab active" id="pills-detail-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-detail" type="button" role="tab" aria-controls="pills-detail"
                                        aria-selected="true">Detail
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link genostab" id="pills-maps-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-maps" type="button" role="tab" aria-controls="pills-maps"
                                        aria-selected="false">Maps
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link genostab" id="pills-gambar1-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-gambar1" type="button" role="tab" aria-controls="pills-gambar1"
                                        aria-selected="false">Gambar 1
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link genostab" id="pills-gambar2-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-gambar2" type="button" role="tab" aria-controls="pills-gambar2"
                                        aria-selected="false">Gambar 2
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link genostab" id="pills-gambar3-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-gambar3" type="button" role="tab" aria-controls="pills-gambar3"
                                        aria-selected="false">Gambar 3
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-detail" role="tabpanel"
                                 aria-labelledby="pills-detail-tab">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="d-provinsi" name="d-provinsi"
                                                   disabled placeholder="Provinsi">
                                            <label for="d-provinsi" class="form-label">Provinsi</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="d-kota" name="d-kota" disabled
                                                   placeholder="Kota">
                                            <label for="d-kota" class="form-label">Kota</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="d-alamat" name="d-alamat" disabled
                                           placeholder="alamat">
                                    <label for="d-alamat" class="form-label">Alamat</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="d-lokasi" name="d-lokasi" disabled
                                           placeholder="lokasi">
                                    <label for="d-lokasi" class="form-label">Lokasi</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="d-urlstreetview" name="d-urlstreetview"
                                           disabled placeholder="urlstreetview">
                                    <label for="d-urlstreetview" class="form-label">URL Street View</label>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="d-latitude" name="d-panjang"
                                                   disabled placeholder="latitude">
                                            <label for="d-panjang" class="form-label">Latitude</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="d-longitude" name="d-longitude"
                                                   disabled placeholder="longitude">
                                            <label for="d-longitude" class="form-label">Longitude</label>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="d-tipe" name="d-tipe" disabled
                                                   placeholder="tipe">
                                            <label for="d-tipe" class="form-label">Tipe</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="d-posisi" name="d-posisi"
                                                   disabled placeholder="posisi">
                                            <label for="d-posisi" class="form-label">Posisi</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="d-panjang" type="number" disabled
                                                   name="d-panjang" placeholder="0">
                                            <label for="d-panjang" class="form-label">Panjang/Tinggi</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="d-lebar" name="d-lebar" disabled
                                                   placeholder="0">
                                            <label for="d-lebar" class="form-label">Lebar</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-maps" role="tabpanel" aria-labelledby="pills-maps-tab">
                                <div class="panel-peta mb-3">
                                    Tampil Peta
                                    <a class="btn-link-maps sml rnd ">Buka di Google Maps <i
                                            class="material-icons menu-icon ms-2">arrow_outward</i></a>
                                </div>

                                <div class="panel-streetview">
                                    Tampil Streetview

                                    <a class="btn-link-maps sml rnd ">Buka di Google Maps <i
                                            class="material-icons menu-icon ms-2">arrow_outward</i></a>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="pills-gambar1" role="tabpanel"
                                 aria-labelledby="pills-gambar1-tab">

                                <div class="panel-gambar" id="showImg1">
                                    {{--                                    <img src="https://smkperdana.sch.id/wp-content/uploads/2021/04/poster-lomba-smp.png"/>--}}
                                </div>

                            </div>

                            <div class="tab-pane fade" id="pills-gambar2" role="tabpanel"
                                 aria-labelledby="pills-gambar2-tab">

                                <div class="panel-gambar" id="showImg2">
                                    <img
                                        src="https://cdns.klimg.com/merdeka.com/i/w/news/2021/09/18/1354258/content_images/670x335/20210918101425-1-jagalah-kebersihan-004-jevi-nugraha.png"/>
                                </div>

                            </div>

                            <div class="tab-pane fade" id="pills-gambar3" role="tabpanel"
                                 aria-labelledby="pills-gambar3-tab">

                                <div class="panel-gambar" id="showImg3">
                                    <img
                                        src="https://assets.pikiran-rakyat.com/crop/0x0:0x0/x/photo/2021/08/19/1012556311.jpg"/>
                                </div>

                            </div>
                        </div>


                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection

@section('morejs')
    <script src="{{ asset('js/number_formater.js') }}"></script>

    <script>
        let image1, image2, image3;
        var s_provinsi, s_kota, s_tipe, s_posisi;
        $(document).ready(function () {
            $('#table_piutang').DataTable();
            datatableItem();
            getSelect('f-provinsi', '/admin/province', 'name', null, 'Semua Provinsi');
            getSelect('type', window.location.pathname + '/type')
            getSelect('f-tipe', window.location.pathname + '/type', 'name', null, 'Semua Type');
            getSelect('f-kota', '/admin/city', 'name', null, 'Semua Kota');

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
            // $('#f-provinsi').select2({
            //     dropdownParent: $("#dropSearch")
            // });
            // $('#f-tipe').select2();
        });

        $(document).on('change', '#province', function () {
            let id = $(this).val();
            getSelect('city', '/admin/province/' + id + '/city');
        });

        $(document).on('change', '#f-provinsi', function (ev) {
            s_provinsi = $(this).val();
            if (s_provinsi === ''){
                getSelect('f-kota', '/admin/city', 'name', null, 'Semua Kota');
            }else{
                getSelect('f-kota', '/admin/province/' + s_provinsi + '/city', 'name', null, 'Semua Kota');
            }
            let text = ev.currentTarget.options[ev.currentTarget.selectedIndex].text;
            pillSearch('provinsi', text);
            datatableItem();
        });
        $(document).on('change', '#f-kota', function (ev) {
            s_kota = $(this).val();
            let text = ev.currentTarget.options[ev.currentTarget.selectedIndex].text;
            pillSearch('kota', text);
            datatableItem();
        });

        $(document).on('change', '#f-tipe', function (ev) {
            s_tipe = $(this).val();
            let text = ev.currentTarget.options[ev.currentTarget.selectedIndex].text;
            pillSearch('tipe', text);
            datatableItem();
        });

        $(document).on('change', '#f-posisi', function (ev) {
            s_posisi = $(this).val();
            let text = ev.currentTarget.options[ev.currentTarget.selectedIndex].text;
            pillSearch('posisi', text);
            datatableItem();
        });

        function pillSearch(a, text) {
            let pill = $('#pillSearch');
            let child = document.getElementById('pill' + a);
            console.log('aaa', a);
            console.log('text', text);
            if (child) {
                $('#pill' + a + ' #text').html(text)
            } else {
                pill.append('<span class="badge bg-primary me-2 " id="pill' + a + '" style="border-radius: 200px; align-items: center"><span id="text">' + text + '</span>  <a role="button" id="removePill" data-id="' + a + '"><i class="material-icons" style="font-size: 12px">close</i></a></span>')
            }
            //

        }

        $(document).on('click', '#removePill', function () {
            let id = $(this).data('id');
            let parent = document.getElementById('pillSearch');
            let child = document.getElementById('pill' + id);
            parent.removeChild(child);
            $('#f-'+id).val('');
            window['s_' + id] = '';
            datatableItem();
        })

        $(document).on('click', '#addData, #editData', function () {
            let id = $(this).data('id');
            let data = $(this).data('row');
            console.log(id);
            console.log(data);
            $('#form #id').val(id);
            $('#form input[type="text"]').val('');
            $('#form input[type="number"]').val('');
            $('#form select').val('');
            let fileImg1 = null, fileImg2 = null, fileImg3 = null, prov = null;
            $('#city').empty();
            if (id) {
                prov = data.city.province.id;
                $('#form #name').val(data.name);
                $('#form #address').val(data.address);
                $('#form #location').val(data.location);
                $('#form #urlstreetview').val(data.url);
                $('#form #latitude').val(data.latitude);
                $('#form #longitude').val(data.longitude);
                $('#form #position').val(data.position);
                $('#form #type').val(data.type);
                $('#form #height').val(data.height);
                $('#form #width').val(data.width);
                getSelect('city', '/admin/province/' + data.city.province.id + '/city', 'name', data.city.id);

                fileImg1 = data.image1;
                fileImg2 = data.image2;
                fileImg3 = data.image3;
            }
            getSelect('province', '/admin/province', 'name', prov);

            setImgDropify('image1', null, fileImg1);
            setImgDropify('image2', null, fileImg2);
            setImgDropify('image3', null, fileImg3);
            $('#modaltambahtitik').modal('show');
        })

        $(document).on('click', '#detailData', function () {
            let data = $(this).data('row');
            $('#d-name').html(data.name);
            $('#d-provinsi').val(data.city.province.name);
            $('#d-kota').val(data.city.name);
            $('#d-alamat').val(data.address);
            $('#d-lokasi').val(data.location);
            $('#d-tipe').val(data.type.name);
            $('#d-urlstreetview').val(data.url);
            $('#d-latitude').val(data.latitude);
            $('#d-longitude').val(data.longitude);
            $('#d-posisi').val(data.position);
            $('#d-panjang').val(data.height);
            $('#d-lebar').val(data.width);
            $('#showImg1').empty();
            $('#showImg2').empty();
            $('#showImg3').empty();
            if (data.image1) {
                $('#showImg1').html('<img src="' + data.image1 + '"  alt=""/>')
            }
            if (data.image2) {
                $('#showImg2').html('<img src="' + data.image2 + '"  alt=""/>')
            }
            if (data.image3) {
                $('#showImg3').html('<img src="' + data.image3 + '"  alt=""/>')
            }

            $('#modaldetail').modal('show')
        });

        function datatableItem() {
            let formData = {
                'province': s_provinsi,
                'city': s_kota,
                'type': s_tipe,
                'position': s_posisi
            };
            let stringData = JSON.stringify(formData);
            var url = '/admin/titik/datatable';

            $('#table_id').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: {
                    'url': url,
                    "data": formData
                },
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    // debugger;
                    var numStart = this.fnPagingInfo().iStart;
                    var index = numStart + iDisplayIndexFull + 1;
                    // var index = iDisplayIndexFull + 1;
                    $("td:first", nRow).html(index);
                    return nRow;
                },
                columns: [
                    {
                        "className": '',
                        "orderable": false,
                        "data": null,
                        "defaultContent": ''
                    },
                    {
                        "data": "city.name",
                        "name": "city.nama"
                    },
                    {
                        "data": "name",
                        "name": "nama"
                    },
                    {
                        "data": "address",
                        "name": "address"
                    },
                    {
                        "data": "height",
                        "name": "height"
                    },
                    {
                        "data": "width",
                        "name": "width"
                    },
                    {
                        "data": "type.name",
                        "name": "type.name"
                    },
                    {
                        "data": "position",
                        "name": "position"
                    },
                    {
                        "data": "id",
                        "render": function (data, type, row) {
                            let string = JSON.stringify(row);
                            return "<div class='d-flex'><a class='btn-utama-soft sml rnd me-1' data-row='" + string + "'  \n" +
                                "                                                  id='detailData'> <i class='material-icons menu-icon'>map</i></a>\n" +
                                "                                <a class='btn-success-soft sml rnd' data-id='" + data + "' data-row='" + string + "' id='editData'> <i class='material-icons menu-icon'>edit</i></a></div>";
                        }
                    },
                ]
            });

        }

        function saveItem() {
            let form = $('#form');
            form.submit(async function (e) {
                e.preventDefault(e);
                let formData = new FormData(this);
                console.log(formData);
                // if ($('#image1').val()) {
                //     let img = await handleImageUpload($('#image1'));
                //     formData.append('image1', img, img.name)
                // }
                // if ($('#image2').val()) {
                //     let img = await handleImageUpload($('#image2'));
                //     formData.append('image2', img, img.name)
                // }
                // if ($('#image3').val()) {
                //     let img = await handleImageUpload($('#image3'));
                //     formData.append('image3', img, img.name)
                // }
                let data = {
                    'form_data': formData,
                    'image': {
                        'image1': 'image1',
                        'image2': 'image2',
                        'image3': 'image3',
                    }
                }
                saveDataAjaxWImage('Simpan Data', 'form', data, window.location.pathname + '/post-item', afterSave);
                return false;
            })
        }

        function afterSave() {
            $('#modaltambahtitik').modal('hide');
            datatableItem();
        }
    </script>
    @endsection


    </body>

    </html>

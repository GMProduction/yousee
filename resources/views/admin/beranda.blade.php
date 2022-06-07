@extends('admin.base')

@section('content')
    <div>


        <div class="panel">
            <div class="title">
                <p>Portfolio</p>
            </div>

            <div class="isi">
                <div class="row" id="cardType">
{{--                    <div class="col-4">--}}
{{--                        <div class="panel-peformace">--}}
{{--                            <img src="{{ asset('images/local/contoh-logo-bunder.png') }}"/>--}}
{{--                            <div class="content">--}}
{{--                                <p class="nama">Baliho</p>--}}
{{--                                <p class="nilai">100 Titik</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="col-4">--}}
{{--                        <div class="panel-peformace">--}}
{{--                            <img src="{{ asset('images/local/contoh-logo-bunder.png') }}"/>--}}
{{--                            <div class="content">--}}
{{--                                <p class="nama">Videotron</p>--}}
{{--                                <p class="nilai">20 Titik</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="col-4">--}}
{{--                        <div class="panel-peformace">--}}
{{--                            <img src="{{ asset('images/local/contoh-logo-bunder.png') }}"/>--}}
{{--                            <div class="content">--}}
{{--                                <p class="nama">Bando Baliho</p>--}}
{{--                                <p class="nilai">50 Titik</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

            </div>

        </div>

        <div class="panel">
            <div class="title">
                <p>Titik yang baru dimasukan</p>
                <a class="btn-utama-soft sml rnd " data-bs-toggle="modal" data-bs-target="#modaltambahtitik">Titik Baru <i
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
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>Solo</td>
                            <td>001</td>
                            <td>Jalan A Yani, Manahan, Banjarsari, surakarta, jawa tengah</td>
                            <td>5</td>
                            <td>10</td>
                            <td>Billboard</td>
                            <td>Horizontal</td>
                            <td class="d-flex"><a class="btn-utama-soft sml rnd me-1" data-bs-toggle="modal"
                                                  data-bs-target="#modaldetail"> <i class="material-icons menu-icon ">map</i></a>
                                <a class="btn-success-soft sml rnd "> <i class="material-icons menu-icon ">edit</i></a>
                            </td>
                        </tr>
                        </tbody>
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

                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nama">

                            </div>
                            <div class="col-md-4 col-sm-12">
                                <label for="provinsi" class="form-label">Provinsi</label>
                                <select class="form-select mb-3" aria-label="Default select example" id="provinsi"
                                        name="provinsi">
                                    <option selected>Pilih Provinsi</option>
                                    <option value="admin">Jawa Tengah</option>
                                    <option value="user">Jakarta</option>
                                </select>
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <label for="kota" class="form-label">Kota</label>
                                <select class="form-select mb-3" aria-label="Default select example" id="kota" name="kota">
                                    <option selected>Pilih Kota</option>
                                    <option value="admin">Surakarta</option>
                                    <option value="user">Semarang</option>
                                </select>
                            </div>

                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat">
                            <label for="alamat" class="form-label">Alamat</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Lokasi">
                            <label for="lokasi" class="form-label">Lokasi</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="urlstreetview" name="urlstreetview"
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
                                <label for="tipe" class="form-label">Tipe</label>
                                <select class="form-select mb-3" aria-label="Default select example" id="tipe" name="type">
                                </select>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <label for="posisi" class="form-label">Posisi</label>
                                <select class="form-select mb-3" aria-label="Default select example" id="posisi"
                                        name="posisi">
                                    <option selected>Pilih Posisi</option>
                                    <option value="admin">Horizontal</option>
                                    <option value="user">Vertical</option>
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="panjang" type="number" name="panjang"
                                           placeholder="0">
                                    <label for="panjang" class="form-label">Panjang/Tinggi</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="lebar" name="lebar" placeholder="lebar">
                                    <label for="lebar" class="form-label">Lebar</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="mb-3">
                                    <label for="gambar1" class="form-label">Gambar 1</label>
                                    <input class="form-control form-control-sm" id="gambar1" type="file">
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <div class="mb-3">
                                    <label for="gambar2" class="form-label">Gambar 2</label>
                                    <input class="form-control form-control-sm" id="gambar2" type="file">
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <div class="mb-3">
                                    <label for="gambar3" class="form-label">Gambar 3</label>
                                    <input class="form-control form-control-sm" id="gambar3" type="file">
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class=" m-3">

                        <div class="row">
                            <div class="col-lg-8">

                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="text-center">
                                    <a class="btn-utama">Simpan</a>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>


        <!-- Modal Detail-->
        <div class="modal fade" id="modaldetail" tabindex="-1" aria-labelledby="modaldetail" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tikik (KODE TITIK)</h5>
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

                                <div class="panel-gambar">
                                    <img src="https://smkperdana.sch.id/wp-content/uploads/2021/04/poster-lomba-smp.png"/>
                                </div>

                            </div>

                            <div class="tab-pane fade" id="pills-gambar2" role="tabpanel"
                                 aria-labelledby="pills-gambar2-tab">

                                <div class="panel-gambar">
                                    <img
                                        src="https://cdns.klimg.com/merdeka.com/i/w/news/2021/09/18/1354258/content_images/670x335/20210918101425-1-jagalah-kebersihan-004-jevi-nugraha.png"/>
                                </div>

                            </div>

                            <div class="tab-pane fade" id="pills-gambar3" role="tabpanel"
                                 aria-labelledby="pills-gambar3-tab">

                                <div class="panel-gambar">
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
        $(document).ready(function () {
            getCard();
            $('#table_piutang').DataTable();
            datatableItem();
            getSelect('tipe',window.location.pathname+'/item/type')
        });

        function datatableItem() {
            var url = '/admin/item/datatable';
            $('#table_id').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: url,
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
                        "render": function (data) {
                            return '<div class="d-flex"><a class="btn-utama-soft sml rnd me-1" data-bs-toggle="modal"\n' +
                                '                                                  data-bs-target="#modaldetail"> <i class="material-icons menu-icon ">map</i></a>\n' +
                                '                                <a class="btn-success-soft sml rnd "> <i class="material-icons menu-icon ">edit</i></a></div>';
                        }
                    },
                ]
            });

        }

        function getCard() {
            $.get('/admin/item/card', function (data, status, response) {
                let card = $('#cardType');
                card.empty;
                if (response.status === 200){
                   $.each(data, function (k,v) {
                       let img = "{{ asset('images/local/contoh-logo-bunder.png') }}"
                       card.append('<div class="col-4">\n' +
                           '                        <div class="panel-peformace">\n' +
                           '                            <img src="'+img+'"/>\n' +
                           '                            <div class="content">\n' +
                           '                                <p class="nama">'+v.name+'</p>\n' +
                           '                                <p class="nilai">'+v.count+' Titik</p>\n' +
                           '                            </div>\n' +
                           '                        </div>\n' +
                           '                    </div>')
                   })
                }
            })
        }
    </script>
    @endsection


    </body>

    </html>

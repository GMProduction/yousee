@extends('admin.base')

@section('content')
    <div>

        <div class="d-flex justify-content-between">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link genostab active" id="pills-tabel-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-tabel" type="button" role="tab" aria-controls="pills-tabel"
                        aria-selected="true">Tabel</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link genostab" id="pills-peta-tab" data-bs-toggle="pill" data-bs-target="#pills-peta"
                        type="button" role="tab" aria-controls="pills-peta" aria-selected="false">Maps</button>
                </li>

            </ul>

            <div>
                <a class="btn-utama sml rnd " href="#" role="button" id="dropdownprofile" data-bs-toggle="dropdown">Filter <i
                        class="material-icons menu-icon ms-2 ">filter_list</i></a>



                <ul class="dropdown-menu custom" aria-labelledby="dropdownprofile">
                    <div class="filter-panel">
                        <div class="form-group">
                            <label for="f-provinsi" class="form-label">Provinsi</label>
                            <select class="form-select mb-3" aria-label="Default select example" id="f-provinsi"
                                name="f-provinsi">
                                <option selected>Pilih Provinsi</option>
                                <option value="jateng">Jawa Tengah</option>
                                <option value="jakarta">Jakarta</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="f-kota" class="form-label">Kota</label>
                            <select class="form-select mb-3" aria-label="Default select example" id="f-kota" name="f-kota">
                                <option selected>Pilih Kota</option>
                                <option value="solo">Solo</option>
                                <option value="jakarta">Jakarta</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="f-tipe" class="form-label">Tipe</label>
                            <select class="form-select mb-3" aria-label="Default select example" id="f-tipe" name="f-tipe">
                                <option selected value="semua">Semua</option>
                                <option value="billboard">Billboard</option>
                                <option value="baliho">baliho</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="f-posisi" class="form-label">Psisi</label>
                            <select class="form-select mb-3" aria-label="Default select example" id="f-posisi"
                                name="f-posisi">
                                <option selected value="semua">Semua</option>
                                <option value="horz">Horizontal</option>
                                <option value="vert">Vertical</option>
                            </select>
                        </div>

                    </div>
                </ul>
            </div>
        </div>

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-tabel" role="tabpanel" aria-labelledby="pills-tabel-tab">
                <div class="panel">
                    <div class="title">
                        <p>Data Titik</p>
                        <div class="d-flex">
                            <a class="btn-utama-soft sml rnd me-2" data-bs-toggle="modal"
                                data-bs-target="#modaltambahtitik">Titik
                                Baru <i class="material-icons menu-icon ms-2">add_circle</i></a>



                        </div>
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
                                        <td class="d-flex"><a class="btn-utama-soft sml rnd me-1"
                                                data-bs-toggle="modal" data-bs-target="#modaldetail"> <i
                                                    class="material-icons menu-icon ">map</i></a>
                                            <a class="btn-success-soft sml rnd "> <i
                                                    class="material-icons menu-icon ">edit</i></a>
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
            </div>
            <div class="tab-pane fade" id="pills-peta" role="tabpanel" aria-labelledby="pills-peta-tab">

                <div class="panel">
                    <div class="title">
                        <p>Data Titik</p>
                        <div class="d-flex">
                            <a class="btn-utama-soft sml rnd me-2" data-bs-toggle="modal"
                                data-bs-target="#modaltambahtitik">Titik
                                Baru <i class="material-icons menu-icon ms-2">add_circle</i></a>


                        </div>
                    </div>


                    <div class="isi">
                        <div class="panel-peta full mb-3">
                            Tampil Peta
                            <a class="btn-link-maps sml rnd ">Buka di Google Maps <i
                                    class="material-icons menu-icon ms-2">arrow_outward</i></a>
                        </div>
                    </div>
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
                            <div class="col-md-6 col-sm-12">
                                <label for="provinsi" class="form-label">Provinsi</label>
                                <select class="form-select mb-3" aria-label="Default select example" id="provinsi"
                                    name="provinsi">
                                    <option selected>Pilih Provinsi</option>
                                    <option value="admin">Jawa Tengah</option>
                                    <option value="user">Jakarta</option>
                                </select>
                            </div>

                            <div class="col-md-6 col-sm-12">
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
                                <select class="form-select mb-3" aria-label="Default select example" id="tipe" name="tipe">
                                    <option selected>Pilih Tipe</option>
                                    <option value="admin">Billboard</option>
                                    <option value="user">Baliho</option>
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
                            <div class="col-lg-4">

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
                                    aria-selected="true">Detail</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link genostab" id="pills-maps-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-maps" type="button" role="tab" aria-controls="pills-maps"
                                    aria-selected="false">Maps</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link genostab" id="pills-gambar1-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-gambar1" type="button" role="tab" aria-controls="pills-gambar1"
                                    aria-selected="false">Gambar 1</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link genostab" id="pills-gambar2-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-gambar2" type="button" role="tab" aria-controls="pills-gambar2"
                                    aria-selected="false">Gambar 2</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link genostab" id="pills-gambar3-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-gambar3" type="button" role="tab" aria-controls="pills-gambar3"
                                    aria-selected="false">Gambar 3</button>
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
                                    <img src="https://smkperdana.sch.id/wp-content/uploads/2021/04/poster-lomba-smp.png" />
                                </div>

                            </div>

                            <div class="tab-pane fade" id="pills-gambar2" role="tabpanel"
                                aria-labelledby="pills-gambar2-tab">

                                <div class="panel-gambar">
                                    <img
                                        src="https://cdns.klimg.com/merdeka.com/i/w/news/2021/09/18/1354258/content_images/670x335/20210918101425-1-jagalah-kebersihan-004-jevi-nugraha.png" />
                                </div>

                            </div>

                            <div class="tab-pane fade" id="pills-gambar3" role="tabpanel"
                                aria-labelledby="pills-gambar3-tab">

                                <div class="panel-gambar">
                                    <img
                                        src="https://assets.pikiran-rakyat.com/crop/0x0:0x0/x/photo/2021/08/19/1012556311.jpg" />
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
        $(document).ready(function() {
            $('#table_id').DataTable();
            $('#table_piutang').DataTable();
        });
    </script>
@endsection


</body>

</html>

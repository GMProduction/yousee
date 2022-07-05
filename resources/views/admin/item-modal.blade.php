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
                        <div class="col-md-3 col-sm-12">
                            <label for="name" class="form-label">Kode</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nama">

                        </div>

                        <div class="col-md-3 col-sm-12">
                            <label for="vendor" class="form-label">Vendor</label>
                            <select class="form-select mb-3 w-full" style="width: 100%" id="vendor" name="vendor_id">
                            </select>
                        </div>

                        <div class="col-md-3 col-sm-12">
                            <label for="province" class="form-label">Provinsi</label>
                            <select class="form-select mb-3 w-full" style="width: 100%" id="province">
                            </select>
                        </div>

                        <div class="col-md-3 col-sm-12">
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
                        <input type="text" class="form-control" id="location" name="location"
                               placeholder="Lokasi">
                        <label for="location" class="form-label">Lokasi</label>
                    </div>


                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="urlstreetview" name="url"
                               placeholder="urlstreetview">
                        <label for="urlstreetview" class="form-label">URL Street View</label>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="latlong" name="latlong"
                                       placeholder="latitude dan longtitude">
                                <label for="latitude" class="form-label">Latitude & Longtitude</label>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <label for="type" class="form-label">Tipe</label>
                            <select class="form-select mb-3" aria-label="Default select example" id="type"
                                    name="type_id">
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
                                <input type="text" class="form-control" id="width" name="width"
                                       placeholder="lebar">
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
                            <button type="submit" class="btn-utama"
                                    style="width: 100%; justify-content: center">Simpan
                            </button>
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

                <ul class="nav nav-pills mb-3" id="pills-tab-detail" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link genostab active" id="pills-detail-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-detail" type="button" role="tab" aria-controls="pills-detail"
                                aria-selected="true">Detail
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link genostab" id="pills-maps-tab-detail" data-bs-toggle="pill"
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
                            <input type="hidden" id="d-id" name="d-id">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="d-Vendor" name="d-Vendor"
                                           disabled placeholder="Vendor">
                                    <label for="d-Vendor" class="form-label">Vendor</label>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="d-provinsi" name="d-provinsi"
                                           disabled placeholder="Provinsi">
                                    <label for="d-provinsi" class="form-label">Provinsi</label>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12">
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
                            <div class="col-sm-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="d-latlong" name="d-panjang"
                                           disabled placeholder="latlong">
                                    <label for="d-panjang" class="form-label">Latitude & Longtitude</label>
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
                        <div class="panel-peta mb-3" id="map-detail">
                            Tampil Peta

                        </div>

                        <div class="panel-streetview" style="display: flex;justify-content: center;width: 100%;">
                            {{--                                    <div class="panel">--}}
                            {{--                                        <div id="map"></div>--}}
                            {{--                                    </div>--}}
                            <div class="gmap_canvas" id="panel-street" style="align-items: center;display: flex;flex: 1;">

                            </div>

                        </div>

                    </div>
                    <div class="tab-pane fade" id="pills-gambar1" role="tabpanel"
                         aria-labelledby="pills-gambar1-tab">
                        <a class="btn-success-soft sml rnd" id="downlodShowImg1" ><i class="material-icons menu-icon">download</i>Download</a>
                        <div class="panel-gambar" id="showImg1">
                        </div>

                    </div>

                    <div class="tab-pane fade" id="pills-gambar2" role="tabpanel"
                         aria-labelledby="pills-gambar2-tab">
                        <a class="btn-success-soft sml rnd" id="downlodShowImg2" ><i class="material-icons menu-icon">download</i>Download</a>

                        <div class="panel-gambar" id="showImg2">
                        </div>

                    </div>

                    <div class="tab-pane fade" id="pills-gambar3" role="tabpanel"
                         aria-labelledby="pills-gambar3-tab">
                        <a class="btn-success-soft sml rnd" id="downlodShowImg3" ><i class="material-icons menu-icon">download</i>Download</a>

                        <div class="panel-gambar" id="showImg3">
                        </div>

                    </div>
                </div>


            </div>


        </div>
    </div>
</div>


<div class="modal fade" id="modalHistory" tabindex="-1" aria-labelledby="modaltambahtitik" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltambahuser">History Update <span id="titleHistory"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table">
                    <tr>
                        <th>#</th>
                        <th class="text-center">Admin</th>
                        <th class="text-center">Tanggal</th>
                    </tr>
                    <tbody id="bodyHistory"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

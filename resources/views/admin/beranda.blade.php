@extends('admin.base')

@section('content')
    <div>


        <div class="panel">
            <div class="title">
                <p>Portfolio</p>
            </div>

            <div class="isi">
                <div class="row">
                    <div class="col-4">
                        <div class="panel-peformace">
                            <img src="{{ asset('images/local/contoh-logo-bunder.png') }}" />
                            <div class="content">
                                <p class="nama">Baliho</p>
                                <p class="nilai">100 Titik</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="panel-peformace">
                            <img src="{{ asset('images/local/contoh-logo-bunder.png') }}" />
                            <div class="content">
                                <p class="nama">Videotron</p>
                                <p class="nilai">20 Titik</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="panel-peformace">
                            <img src="{{ asset('images/local/contoh-logo-bunder.png') }}" />
                            <div class="content">
                                <p class="nama">Bando Baliho</p>
                                <p class="nilai">50 Titik</p>
                            </div>
                        </div>
                    </div>
                </div>

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
                                <td class="d-flex"><a class="btn-utama-soft sml rnd me-1"> <i
                                            class="material-icons menu-icon ">map</i></a>
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
                            <div class="col-6">
                                <label for="provinsi" class="form-label">Provinsi</label>
                                <select class="form-select mb-3" aria-label="Default select example" id="provinsi"
                                    name="provinsi">
                                    <option selected>Pilih Provinsi</option>
                                    <option value="admin">Jawa Tengah</option>
                                    <option value="user">Jakarta</option>
                                </select>
                            </div>

                            <div class="col-6">
                                <label for="kota" class="form-label">Kota</label>
                                <select class="form-select mb-3" aria-label="Default select example" id="kota" name="kota">
                                    <option selected>Pilih Kota</option>
                                    <option value="admin">Surakarta</option>
                                    <option value="user">Semarang</option>
                                </select>
                            </div>

                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Jhony">
                            <label for="alamat" class="form-label">Alamat</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Jhony">
                            <label for="lokasi" class="form-label">Lokasi</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="urlstreetview" name="urlstreetview"
                                placeholder="Jhony">
                            <label for="urlstreetview" class="form-label">URL Street View</label>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="latitude"  name="panjang"
                                        placeholder="latitude">
                                    <label for="panjang" class="form-label">Latitude</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="latitude" name="latitude" placeholder="0">
                                    <label for="latitude" class="form-label">Latitude</label>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-6">
                                <label for="tipe" class="form-label">Tipe</label>
                                <select class="form-select mb-3" aria-label="Default select example" id="tipe" name="tipe">
                                    <option selected>Pilih Tipe</option>
                                    <option value="admin">Billboard</option>
                                    <option value="user">Baliho</option>
                                </select>
                            </div>

                            <div class="col-6">
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
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="panjang" type="number" name="panjang"
                                        placeholder="0">
                                    <label for="panjang" class="form-label">Panjang/Tinggi</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="lebar" name="lebar" placeholder="0">
                                    <label for="lebar" class="form-label">Lebar</label>
                                </div>
                            </div>
                        </div>

                        

                    </div>

                    <div class=" m-3">

                        <div class="text-center">
                            <a class="btn-utama">Simpan</a>
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

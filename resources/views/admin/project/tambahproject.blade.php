@extends('admin.base')

@section('title')
    Tambah Project Yousee
@endsection

@section('css')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/project">Project</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Project</li>
        </ol>
    </nav>

    <div>
        <div class="row">
            <div class="col-4">
                <div class="panel p-4">
                    <form id="form" enctype="multipart/form-data">
                        @csrf
                        <input id="id" name="id" hidden>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="inp_nama" name="inp_nama" required
                                placeholder="Nama Project">
                            <label for="inp_nama" class="form-label">Nama Project</label>
                        </div>

                        <div class="form-floating mb-3 nput-group date " id="datepicker" data-provide="datepicker">
                            <input type="text" class="form-control" id="date" name="inp_tgl_req" required
                                placeholder="Tanggal Request">
                            <label for="date" class="form-label">Tanggal Request</label>
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>

                        <div class="d-flex align-items-stretch mb-3 ">
                            <div class="form-floating me-1">
                                <input type="text" class="form-control" id="inp_durasi" name="inp_durasi" required
                                    placeholder="Nama Tipe">
                                <label for="inp_durasi" class="form-label">Durasi</label>
                            </div>
                            <select class="form-select" aria-label="Default select example">
                                <option selected>Pilih Durasi</option>
                                <option value="1">Hari</option>
                                <option value="2">Bulan</option>
                                <option value="3">Tahun</option>
                            </select>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="inp_budget" name="inp_budget" required
                                placeholder="Nama Tipe">
                            <label for="inp_budget" class="form-label">Budget</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="inp_pic_client" name="inp_pic_client" required
                                placeholder="Nama PIC">
                            <label for="inp_budget" class="form-label">PIC Client</label>
                        </div>

                        <div class="mb-3 ">
                            <label for="inp_berlampu" class="form-label">Berlampu</label>
                            <div class="d-flex">
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="radio" name="inp_berlampu" id="inp_berlampu_ya">
                                    <label class="form-check-label" for="inp_berlampu_ya">
                                        Ya
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="inp_berlampu"
                                        id="inp_berlampu_tidak" checked>
                                    <label class="form-check-label" for="inp_berlampu_tidak">
                                        Tidak
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mb-3 ">
                            <textarea style="height: auto;" type="text" class="form-control" id="name" name="name" rows="10"
                                required placeholder="Nama Tipe"></textarea>
                            <label for="name" class="form-label">Keterangan</label>
                        </div>

                        <div class="my-3">
                            <div class="d-flex">
                                <button type="submit" class="btn-utama" style="width: 100%">Simpan</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <div class="col-8">
                <div class="panel mb-1">
                    <div class="title">
                        <p>Data Titik</p>
                        <div class="d-flex">
                            <a class="btn-success-soft sml rnd me-2" data-bs-toggle="modal"
                                data-bs-target="#modaltambahpictitik">Tambah PIC titik<i
                                    class="material-symbols-outlined menu-icon ms-2 text-success">add_circle</i></a>

                            <a class="btn-utama-soft sml rnd " data-bs-toggle="modal" data-bs-target="#modaltambahtitik"
                                id="addData">Tambah Titik <i
                                    class="material-symbols-outlined menu-icon ms-2 text-grey">arrow_right_alt</i></a>
                        </div>
                    </div>
                    <div class="isi">
                        <div class="table">
                            <table id="table_id" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kota </th>
                                        <th>Lokasi titik</th>
                                        <th>PIC /titik</th>
                                        <th>Harga Vendor</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <td>1</td>
                                    <td>Kota</td>
                                    <td>Lokasi titik</td>
                                    <td>PIC /titik</td>
                                    <td>Harga Vendor</td>
                                    <td>
                                        <div class='d-flex'><a class="btn-success sml rnd  me-1"> <i
                                                    class='material-symbols-outlined menu-icon text-white'>edit</i></a>

                                            <a class="btn-danger sml rnd  me-1" href="project/addproject">
                                                <i class='material-symbols-outlined menu-icon text-white'>delete</i></a>

                                        </div>
                                    </td>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Kota </th>
                                        <th>Lokasi titik</th>
                                        <th>PIC /titik</th>
                                        <th>Harga Vendor</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="panel p-4">
                    <div class="d-flex">
                        <span class="material-symbols-outlined menu-icon me-2">
                            info
                        </span>
                        <div>
                            <div>
                                <a>Solo : 2,</a>
                                <a>Semarang : 2,</a>
                            </div>

                            <div>
                                <a>Agam : 2,</a>
                                <a>Mail : 2,</a>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
        <!-- Modal Tambah Titik-->
        <div class="modal fade" id="modaltambahtitik" tabindex="-1" aria-labelledby="modaltambahtitik"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modaltambahuser">Tambah Titik</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-8">
                                <div class="table">
                                    <table id="table_id" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Kota </th>
                                                <th>Alamat </th>
                                                <th>Vendor </th>
                                                <th>Panjang </th>
                                                <th>Lebar </th>
                                                <th>Type </th>
                                                <th>Posisi </th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Solo</td>
                                                <td>Jl. Ontorejo no 8 </td>
                                                <td>Vendor A</td>
                                                <td>5</td>
                                                <td>9</td>
                                                <td>Billboard</td>
                                                <td>Vertical</td>
                                                <td>
                                                    <div class='d-flex'><a class="btn-utama sml rnd  me-1"
                                                            href="project/addproject" id="addData"> <i
                                                                class='material-symbols-outlined menu-icon text-white'>arrow_right_alt</i></a>


                                                    </div>
                                                </td>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Kota </th>
                                                <th>Alamat </th>
                                                <th>Vendor </th>
                                                <th>Panjang </th>
                                                <th>Lebar </th>
                                                <th>Type </th>
                                                <th>Posisi </th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="panel p-4">
                                    <form id="form" enctype="multipart/form-data">
                                        @csrf
                                        <input id="id" name="id" hidden>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="kota" name="kota"
                                                placeholder="Kota" readonly>
                                            <label for="kota" class="form-label">Kota</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="alamat" name="alamat"
                                                placeholder="Alamat" readonly>
                                            <label for="alamat" class="form-label">Alamat</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="panjang" name="panjang"
                                                placeholder="Panjang" readonly>
                                            <label for="panjang" class="form-label">Panjang</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="lebar" name="lebar"
                                                placeholder="Lebar" readonly>
                                            <label for="lebar" class="form-label">Lebar</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="tipe" name="tipe"
                                                placeholder="tipe" readonly>
                                            <label for="tipe" class="form-label">Tipe</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="inp_namapic"
                                                name="inp_namapic" required placeholder="Nama PIC">
                                            <label for="inp_namapic" class="form-label">Nama PIC</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="inp_hargavendor"
                                                name="inp_hargavendor" required placeholder="Harga Vendor">
                                            <label for="inp_hargavendor" class="form-label">Harga Vendor</label>
                                        </div>

                                        <div class="my-3">
                                            <div class="d-flex">
                                                <button type="submit" class="btn-utama"
                                                    style="width: 100%">Simpan</button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal PIC Titik -->
        <div class="modal fade" id="modaltambahpictitik" tabindex="-1" aria-labelledby="modaltambahpictitik"
            aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modaltambahuser">Tambah PIC Titik</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


                        <div class="panel p-4">
                            <form id="form" enctype="multipart/form-data">
                                @csrf
                                <input id="id" name="id" hidden>

                                <div class="mb-3">
                                    <label for="in_kota" class="form-label">Pilih Kota</label>
                                    <select id="in_kota" name="in_kota" class="form-select "
                                        aria-label="Default select example">
                                        <option selected>Pilih Kota</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="in_namapic" name="in_namapic"
                                        required placeholder="Nama PIC">
                                    <label for="in_namapic" class="form-label">Nama PIC</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="in_hargavendor" name="in_hargavendor"
                                        required placeholder="Harga Vendor">
                                    <label for="in_hargavendor" class="form-label">Harga Vendor</label>
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
        </div>

    </div>
@endsection

@section('morejs')
    <script src="{{ asset('js/number_formater.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        $(function() {
            $('#datepicker').datepicker({
                format: 'dd/mm/yyyy',
                todayHighlight: 'TRUE',
                autoclose: true,
            });
        });
    </script>
@endsection

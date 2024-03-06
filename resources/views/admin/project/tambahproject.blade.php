@extends('admin.base')

@section('title')
    Tambah Project Yousee
@endsection

@section('css')
    <link href="https://cdn.datatables.net/select/1.7.0/css/select.dataTables.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

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

        .iconsClass {
            line-height: 0.5 !important;
        }
    </style>
@endsection
@section('content')
    {{--    <script src="{{ asset('css/summernote/summernote.css') }}"></script> --}}
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <div class="d-flex justify-content-between mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/project">Project</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Project</li>
            </ol>
        </nav>
        @if ($data)
            <div class="d-flex gap-2 ">
                <a style="150px" class="btn-warnings sml  flex-fill " href="/admin/report/{{ request('q') }}/1"
                    target="_blank">Export PDF (Penawaran)<i
                        class="material-symbols-outlined menu-icon ms-2 text-white">picture_as_pdf</i></a>

                <a style="150px" class="btn-warnings sml  flex-fill " href="/admin/report/{{ request('q') }}/2"
                    target="_blank">Export PDF (Internal)<i
                        class="material-symbols-outlined menu-icon ms-2 text-white">picture_as_pdf</i></a>

                <a style="150px" class="btn-success sml flex-fill "
                    href="{{ route('export.excell', ['id' => request('q')]) }}">Export
                    Excel<i class="material-symbols-outlined menu-icon ms-2 text-white">border_all</i></a>
            </div>
        @endif

    </div>
    <div>
        <div class="d-flex flex-column">

            <div class="">
                <div class="panel p-4 ">
                    <form id="formProject" class="row" onsubmit="return saveForm()">
                        @csrf
                        <div class="col-md-6">
                            <input id="id" name="id" value="{{ request('q') }}" hidden>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="inp_nama" name="name" required
                                    value="{{ $data ? $data->name : '' }}" placeholder="Nama Project">
                                <label for="inp_nama" class="form-label">Nama Project</label>
                            </div>

                            <div class="form-floating mb-3 nput-group date datepicker" id="datepicker"
                                data-provide="datepicker">
                                <input type="text" class="form-control" id="date" name="request_date" required
                                    onchange="changeDate(this)"
                                    value="{{ $data ? date('d/m/Y', strtotime($data->request_date)) : '' }}"
                                    placeholder="Tanggal Request">
                                <label for="date" class="form-label">Tanggal Request</label>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>


                            {{-- <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="inp_budget" name="inp_budget" required
                                       placeholder="Nama Tipe">
                                <label for="inp_budget" class="form-label">Budget</label>
                            </div> --}}

                            <div class="d-flex align-items-stretch mb-3 ">
                                <div class="form-floating me-1">
                                    <input type="text" class="form-control" id="inp_durasi" name="duration" required
                                        value="{{ $data ? $data->duration : '' }}" placeholder="Nama Tipe">
                                    <label for="inp_durasi" class="form-label">Durasi</label>
                                </div>
                                <select class="form-select" aria-label="Default select example" id="duration_unit"
                                    name="duration_unit">
                                    <option selected>Pilih Durasi</option>
                                    <option value="Hari">Hari</option>
                                    <option value="Minggu">Minggu</option>
                                    <option value="Bulan">Bulan</option>
                                    <option value="Tahun">Tahun</option>
                                </select>
                            </div>

                            <div class="form-floating  ">
                                <textarea style="height: auto;" type="text" class="form-control" id="description" name="description" rows="10"
                                    required placeholder="Nama Tipe">{{ $data ? $data->description : '' }}</textarea>
                                {{--                            <div id="description"></div> --}}
                                {{--                               <label for="description" class="form-label">Keterangan</label> --}}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="inp_pic_client" name="client_pic" required
                                    value="{{ $data ? $data->client_pic : '' }}" placeholder="Nama PIC">
                                <label for="inp_budget" class="form-label">PIC Client</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="from" name="from"
                                    value="{{ $data ? $data->from : '' }}" required placeholder="Nama Pembuat">
                                <label for="to_name" class="form-label">Nama Pembuat</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="to_name" name="to_name"
                                    value="{{ $data ? $data->to_name : '' }}" required placeholder="Nama Penerima">
                                <label for="to_name" class="form-label">Nama Penerima</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="number_doc" name="number_doc"
                                    value="{{ $data ? $data->number_doc : '' }}" required placeholder="Nomor Surat">
                                <label for="number_doc" class="form-label">Nomor Suarat</label>
                            </div>

                            <div class="d-flex w-100 gap-4 ">
                                <button type="submit" class="btn-utama flex-fill"><span
                                        class="d-flex justify-content-center align-items-center ">
                                        @if (request('q'))
                                            Simpan Hasil Perubahan
                                        @else
                                            Simpan
                                        @endif
                                        <i class="material-symbols-outlined menu-icon ms-2 text-white">save</i>
                                    </span>
                                </button>

                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <div class="panel">
                <div class="title">
                    <p>Gambar Titik</p>
                </div>
                <div class="isi">
                    <div class="row" id="divImg">
                    </div>
                </div>
            </div>
            <div class="">
                <div class="panel mb-1">
                    <div class="title d-flex flex-column">
                        <p class="mb-2">Data Titik</p>
                        @if (request('q'))
                            <div class="d-flex gap-2 flex-md-row flex-column justify-content-between ">

                                <div class="d-flex gap-2">
                                    <a class="btn-success-soft sml rnd  " id="addPic"><span
                                            class="d-flex align-items-center">Tambah PIC
                                            titik<i
                                                class="material-symbols-outlined menu-icon ms-2 text-success">add_circle</i></span></a>

                                    <a class="btn-utama-soft sml rnd " id="addDataTitik">Tambah Titik <i
                                            class="material-symbols-outlined menu-icon ms-2 text-grey">arrow_right_alt</i></a>
                                </div>

                                <div class="d-flex gap-2">
                                    @if (auth()->user()->role == 'pimpinan')
                                        <a class="btn-success sml rnd "
                                            href="/admin/project/buatharga/{{ request('q') }}">Buat Harga<i
                                                class="material-symbols-outlined menu-icon ms-2 text-white">receipt_long</i></a>
                                    @endif
                                    <a class="btn-utama sml rnd d-flex align-items-center" data-bs-toggle="modal"
                                        data-bs-target="#modalShare">Gunakan Titik Untuk
                                        Project
                                        Baru<i
                                            class="material-symbols-outlined menu-icon ms-2 text-white">arrow_right_alt</i></a>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="isi">
                        <div class="table table-responsive">
                            <table id="table_id" class="table " style="width:100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="text-center">
                                                <input class="form-check-input selectalltable text-center" type="checkbox"
                                                    value="" onclick="selectAll()" id="checkRow">
                                            </div>
                                        </th>
                                        <th>No</th>
                                        <th>Tipe</th>
                                        <th>Kota</th>
                                        <th>Vendor</th>
                                        <th>Ukuran</th>
                                        <th>PIC</th>
                                        <th>Deskripsi</th>
                                        <th>Harga Vendor</th>
                                        <th>Action</th>
                                        <th>Order</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>No</th>
                                        <th>Tipe</th>
                                        <th>Kota</th>
                                        <th>Vendor</th>
                                        <th>Lokasi titik</th>
                                        <th>PIC</th>
                                        <th>Deskripsi</th>
                                        <th>Harga Vendor</th>
                                        <th>Action</th>
                                        <th>Order</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
                @if (request('q'))
                    <div class="panel p-4">
                        <div class="d-flex flex-column">
                            <div class="d-flex">
                                <span class="material-symbols-outlined menu-icon me-2">info</span>
                                <div>
                                    <div id="countCity">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex mt-2">
                                <span class="material-symbols-outlined menu-icon me-2">info</span>
                                <div>
                                    <div id="countPic">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                @endif
            </div>

        </div>
        <!-- Modal Tambah Titik-->
        <div class="modal fade" id="modaltambahtitik" tabindex="-1" aria-labelledby="modaltambahtitik"
            aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modaltambahuser">Tambah Titik</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-8">
                                <div class="table-responsive">
                                    <div class="table">
                                        <table id="tambahtitik" class="table table-striped" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Foto</th>
                                                    <th>Kota</th>
                                                    <th>Alamat</th>
                                                    <th>Vendor</th>
                                                    <th>Lebar</th>
                                                    <th>Tinggi</th>
                                                    <th>Type</th>
                                                    <th>Posisi</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Foto</th>
                                                    <th>Kota</th>
                                                    <th>Alamat</th>
                                                    <th>Vendor</th>
                                                    <th>Lebar</th>
                                                    <th>Tinggi</th>
                                                    <th>Type</th>
                                                    <th>Posisi</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="panel p-4">

                                    <form id="formTitik" onsubmit="return saveTitik()">
                                        @csrf
                                        <div class="row">
                                            <div class="col-6">
                                                <input id="id" name="id" hidden>
                                                <input id="idTitik" name="item_id" hidden>
                                                <input id="city_id" name="city_id" hidden>
                                                <input id="idTitik" name="action" value="titik" hidden>

                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="kota"
                                                        name="kota" placeholder="Kota" readonly>
                                                    <label for="kota" class="form-label">Kota</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="alamat"
                                                        name="alamat" placeholder="Alamat" readonly>
                                                    <label for="alamat" class="form-label">Alamat</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="tinggi"
                                                        name="tinggi" placeholder="Tinggi" readonly>
                                                    <label for="tinggi" class="form-label">Tinggi</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="lebar"
                                                        name="lebar" placeholder="Lebar" readonly>
                                                    <label for="lebar" class="form-label">Lebar</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="tipe"
                                                        name="tipe" placeholder="tipe" readonly>
                                                    <label for="tipe" class="form-label">Tipe</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="nama_vendor"
                                                        name="nama_vendor" placeholder="nama_vendor" readonly>
                                                    <label for="nama_vendor" class="form-label">Nama Vendor</label>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class=" mb-3">
                                                    <input id="idPic" name="idPic" hidden>
                                                    {{--                                            <input type="text" class="form-control" id="inp_namapic" --}}
                                                    {{--                                                   name="inp_namapic" required placeholder="Nama PIC"> --}}
                                                    <label for="inp_namapic" class="form-label">Nama PIC</label>
                                                    <select id="inp_namapic" required name="pic_id" class="form-select "
                                                        style="width: 100%" aria-label="Default select example">
                                                    </select>
                                                </div>

                                                <div class="mb-3 ">
                                                    <label for="inp_berlampu" class="form-label">Berlampu</label>
                                                    <div class="d-flex">
                                                        <div class="form-check me-3">
                                                            <input class="form-check-input" type="radio"
                                                                name="is_lighted" value="1" id="inp_berlampu_ya">
                                                            <label class="form-check-label" for="inp_berlampu_ya">
                                                                Ya
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="is_lighted" value="0" id="inp_berlampu_tidak"
                                                                checked>
                                                            <label class="form-check-label" for="inp_berlampu_tidak">
                                                                Tidak
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="statAvail"
                                                        value="Tersedia" id="checkAvail" onchange="changeAvail()">
                                                    <label class="form-check-label" for="checkAvail">
                                                        Tersedia
                                                    </label>
                                                </div>
                                                <div class="form-floating mb-3 input-group date datepicker"
                                                    id="tanggaltersedia" data-provide="datepicker">

                                                    <input type="text" class="form-control" id="date"
                                                        onchange="changeData(this)" name="dateAvail" required
                                                        value="" placeholder="Tersedia Tanggal">
                                                    <label for="date" class="form-label">Tersedia Tanggal</label>
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-th"></span>
                                                    </div>
                                                </div>

                                                <div class="form-floating mb-3">
                                                    <input type="text" pattern="[0-9,]+" class="form-control"
                                                        id="inp_hargavendor"
                                                        oninvalid="this.setCustomValidity('Harga tidak sesuai')"
                                                        onchange="this.setCustomValidity('')" name="vendor_price" required
                                                        placeholder="Harga Vendor">
                                                    <label for="inp_hargavendor" class="form-label">Harga dari
                                                        Vendor</label>
                                                </div>

                                                {{--                                                <div class="panel p-2 bg-primary-grey"> --}}
                                                {{--                                                    <p>Harga Dari Vendor <span class="unset text-primary">(Optional)</span> --}}
                                                {{--                                                    </p> --}}
                                                {{--                                                    <div class="form-floating mb-3"> --}}
                                                {{--                                                        <input type="number" class="form-control" id="inp_harga1" --}}
                                                {{--                                                               name="inp_harga1" placeholder="Harga Vendor"> --}}
                                                {{--                                                        <label for="inp_harga1" class="form-label">Harga 1 --}}
                                                {{--                                                            Bulan</label> --}}
                                                {{--                                                    </div> --}}
                                                {{--                                                    <div class="form-floating mb-3"> --}}
                                                {{--                                                        <input type="number" class="form-control" id="inp_harga3" --}}
                                                {{--                                                               name="inp_harga3" placeholder="Harga Vendor"> --}}
                                                {{--                                                        <label for="inp_harga3" class="form-label">Harga 3 --}}
                                                {{--                                                            Bulan</label> --}}
                                                {{--                                                    </div> --}}
                                                {{--                                                    <div class="form-floating mb-3"> --}}
                                                {{--                                                        <input type="number" class="form-control" id="inp_harga6" --}}
                                                {{--                                                               name="inp_harga6" placeholder="Harga Vendor"> --}}
                                                {{--                                                        <label for="inp_harga6" class="form-label">Harga 6 --}}
                                                {{--                                                            Bulan</label> --}}
                                                {{--                                                    </div> --}}
                                                {{--                                                    <div class="form-floating mb-3"> --}}
                                                {{--                                                        <input type="number" class="form-control" id="inp_harga12" --}}
                                                {{--                                                               name="inp_harga12" placeholder="Harga Vendor"> --}}
                                                {{--                                                        <label for="inp_harga12" class="form-label">Harga 12 --}}
                                                {{--                                                            Bulan</label> --}}
                                                {{--                                                    </div> --}}
                                                {{--                                                </div> --}}
                                            </div>
                                        </div>

                                        <div class="my-3">
                                            <div class="d-flex">
                                                <button type="submit" class="btn-utama" style="width: 100%">Simpan
                                                </button>
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
                            <form id="formPIC" onsubmit="return saveFormPIC()">
                                @csrf
                                <input id="id" name="id" hidden>
                                <div class="mb-3">
                                    <label for="in_kota" class="form-label">Pilih Provinsi</label>
                                    <select id="province" required name="province" class="form-select "
                                        style="width: 100%" aria-label="Default select example">
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="city" class="form-label">Pilih Kota</label>
                                    <select id="city" required name="city_id" class="form-select "
                                        style="width: 100%" aria-label="Default select example">
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="pic_id" class="form-label">Nama PIC</label>
                                    <select id="pic_id" required name="pic_id" class="form-select "
                                        style="width: 100%" aria-label="Default select example">
                                    </select>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="in_jumlah" name="qtyPic" required
                                        placeholder="Jumlah">
                                    <label for="in_jumlah" class="form-label">Jumlah</label>
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

        <div class="modal fade" id="modalShare" tabindex="-1" aria-labelledby="modaltambahtitik" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modaltambahuser">Pilih Project</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


                        <div class="panel p-4">
                            <div class="table">
                                <table id="tabelShare" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Project</th>
                                            <th>PIC /titik</th>
                                            <th>Durasi</th>
                                            {{--                                    <th>Status</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{--                                <tr> --}}
                                        {{--                                    <td>#</td> --}}
                                        {{--                                    <td>Nama Project</td> --}}
                                        {{--                                    <td>Tanggal Request</td> --}}
                                        {{--                                    <td>Jumlah Titik</td> --}}
                                        {{--                                    <td>PIC Client</td> --}}
                                        {{--                                    <th>Status</th> --}}
                                        {{--                                    <td> --}}

                                        {{--                                        <div class='d-flex'> --}}
                                        {{--                                            <a class="btn-success sml rnd  me-1" href="/admin/project/detail/1" --}}
                                        {{--                                               id="addData">Masukan Dalam Project --}}
                                        {{--                                                <i class='material-symbols-outlined menu-icon text-white'>arrow_right_alt</i></a> --}}
                                        {{--                                        </div> --}}
                                        {{--                                    </td> --}}
                                        {{--                                </tr> --}}
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Project</th>
                                            <th>PIC /titik</th>
                                            <th>Durasi</th>
                                            {{--                                    <th>Status</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Modal -->
        @include('admin.item-modal')
    </div>
@endsection

@section('morejs')
    <script src="{{ asset('js/map-control.js?v=2') }}"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1MgLuZuyqR_OGY3ob3M52N46TDBRI_9k&callback=initMap&v=weekly"
        async></script>
    <script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.4.1/js/dataTables.rowReorder.min.js"></script>
    <script src="https://editor.datatables.net/extensions/Editor/js/dataTables.editor.min.js"></script>
    <script src="{{ asset('js/number_formater.js') }}"></script>
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ asset('js/currency.js') }}"></script>
    {{--    <script src="{{ asset('css/summernote/summernote.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <script src="{{ asset('js/item.js?v=4') }}"></script>

    <script>
        let param, prov, pic_id;
        var urlTitik = "/data/item/datatable";
        let idProject = ''

        function toFixedWithoutZeros(num, precision) {
            return num.toFixed(precision).replace(/\.0+$/, '')
        }

        $(document).ready(function() {
            param = '{{ request('q') }}'
            $('#duration_unit').val('{{ $data ? $data->duration_unit : '' }}')
            $('#project_id').val(param)
            $('#inp_berlampu_ya').prop('checked', '{{ $data && $data->is_lighted == 1 ? true : false }}')
            $('#inp_berlampu_tidak').prop('checked', '{{ $data && $data->is_lighted == 0 ? true : false }}')
            // $('#tambahtitik').DataTable();
            currency('inp_hargavendor');
            $('#description').summernote({
                toolbar: [
                    // [groupName, [list of button]]
                    // ['style', ['bold', 'italic', 'underline', 'clear']],
                    // ['font', ['strikethrough', 'superscript', 'subscript']],
                    // ['fontsize', ['fontsize']],
                    // ['color', ['color']],
                    ['para', ['ul', 'ol']],
                    // ['height', ['height']]
                ]
            });
            $('#titik').DataTable();
            $('#province').select2({
                dropdownParent: $("#modaltambahpictitik")
            });
            $('#city').select2({
                dropdownParent: $("#modaltambahpictitik")
            });
            $('#pic_id').select2({
                dropdownParent: $("#modaltambahpictitik")
            });
            $('#inp_namapic').select2({
                dropdownParent: $("#modaltambahtitik")
            });
            showTable()
            showDatatableItem()
            showDatatableItemProject()
            idProject = '{{ request('q') }}'
            getCountCity()
            getCountPIC()

        });

        function changeDate(a) {
            console.log($(a).val())
        }

        $(document).on('click', '#addPic', function() {
            getSelect("province", "/data/province", "name", prov, "Pilih Provinsi");
            getSelect("pic_id", "{{ route('user.get.json') }}", "nama", pic_id, "Pilih PIC");
            $('#modaltambahpictitik #city').empty().trigger('change')
            $('#modaltambahpictitik #in_jumlah').val('1')
            $('#modaltambahpictitik').modal('show')
        })

        function getCountCity() {
            let divCity = $('#countCity')
            divCity.empty()
            let url = '{{ route('tambahproject.count.city', ['id' => 'vallll']) }}'
            url = url.split('vallll').join(idProject)
            $.get(url, function(req) {
                $.each(req, function(k, v) {
                    divCity.append('<div>' +
                        '<label>' + v.name + ' : ' + v.count + '</label>' +
                        '</div>')
                })
            })
        }

        function getCountPIC() {
            let divCity = $('#countPic')
            divCity.empty()
            let url = '{{ route('tambahproject.count.pic', ['id' => 'vallll']) }}'
            url = url.split('vallll').join(idProject)
            $.get(url, function(req) {
                $.each(req, function(k, v) {
                    divCity.append('<div>' +
                        '<label>' + v.nama + ' : ' + v.count + '</label>' +
                        '</div>')
                })
            })
        }

        function changeAvail() {
            let check = $('#checkAvail').prop('checked');
            $('#modaltambahtitik #date').val('');
            if (check) {
                $('#modaltambahtitik #date').attr('disabled', '')
            } else {
                $('#modaltambahtitik #date').removeAttr('disabled')
            }
        }

        $(function() {
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                todayHighlight: 'TRUE',
                autoclose: true,
            });
        });

        $(document).on("change", "#province", function() {
            let id = $(this).val();
            getSelect(
                "city",
                "/data/province/" + id + "/city",
                "name",
                null,
                "Pilih Kota"
            );
        });


        function showTable() {
            let column = [{
                    "className": 'select-checkbox',
                    "orderable": false,
                    "defaultContent": '',
                    'checkboxes': {
                        'selectRow': true
                    }
                }, {
                    "data": "index_number",
                    "name": "index_number",
                    "className": 'align-middle',
                    "orderable": false,
                    "render": function(data) {
                        return parseInt(data) + 1
                    }
                },
                {
                    "data": "item.type.name",
                    "name": "item.type.name",
                    "orderable": false,
                    "className": 'align-middle',
                },
                {
                    "data": "city.name",
                    "name": "city.name",
                    "orderable": false,
                    "className": 'align-middle',
                    render: (data, x, row) => {
                        return '<div class="d-flex flex-column">' +
                            '<label>' + data + '</label>' +
                            '<label class="text-muted">' + row?.item?.address + '</label>' +
                            '<label class="text-muted">' + row?.item?.location + '</label>' +
                            '</div>'
                    }
                },
                {
                    "data": "item.vendor_all.name",
                    "name": "item.vendorAll.name",
                    "orderable": false,
                },
                {
                    "data": "item.address",
                    "name": "item.address",
                    "orderable": false,
                    "className": 'align-middle',
                    render: function(data, x, row) {
                        return '<div class="d-flex flex-column">' +
                            '<label>' + toFixedWithoutZeros(parseFloat(row?.item.height), 2) + ' x ' +
                            toFixedWithoutZeros(parseFloat(row?.item.width), 2) + '</label>' +
                            '<label>' + row?.item.position + '</label>' +
                            '</div>'
                    }
                },
                {
                    "data": "pic.nama",
                    "orderable": false,
                    "name": "pic.nama",
                },
                {
                    "data": "pic.nama",
                    "orderable": false,
                    "name": "pic.nama",
                    render: (data, x, row) => {
                        let light = row?.is_lighted ? "Ya" : 'Tidak';
                        let avail = row?.available;
                        return '<div class="d-flex flex-column">' +
                            '<span>Berlampu : ' + light + '</span>' +
                            '<span>Ketersediaan : ' + avail + '</span>' +
                            '</div>'
                    }
                },
                {
                    "data": "vendor_price",
                    "name": "vendor_price",
                    "orderable": false,
                    "render": function(data) {
                        return 'Rp. ' + data.toLocaleString()
                    }
                },
                {
                    "data": "id",
                    searchable: false,
                    "render": function(data, type, row) {
                        return "<div class='d-flex gap-2'>\n" +
                            // "                                <a class='btn-success-soft sml rnd' data-id='" +
                            // data + "'  id='editData'> <i class='material-symbols-outlined menu-icon'>edit</i></a>" +
                            "                               " +
                            " <a class='btn-success sml rnd' data-itemid='" + row?.item_id + "' data-tipe='" +
                            row?.item?.type?.name + "' data-tinggi='" + row?.item?.height + "' data-lebar='" + row
                            ?.item?.width + "' data-lokasi='" + row?.item?.location + "' data-kotaid='" + row
                            .city_id + "' data-kota='" + row?.city?.name + "' data-picnama='" + row?.pic
                            ?.nama + "' data-pic_id='" + row.pic_id + "' data-harga='" + row?.vendor_price +
                            "' data-available='" + row?.available + "' data-light='" + row?.is_lighted +
                            "' data-id='" + data +
                            "'  id='mapData'> <i class='material-symbols-outlined menu-icon text-white'>edit</i></a>" +
                            " <a class='btn-danger sml rnd  me-1' data-id='" + data +
                            "' role='button' id='deleteTitik'> <i" +
                            "    class='material-symbols-outlined menu-icon text-white'>delete</i></a>" +
                            "</div>";
                    }
                },
                {
                    data: 'index_number',
                    name: 'order',
                    "orderable": false,
                    defaultContent: '',
                    className: 'orderRow',
                    fieldInfo: 'This field can only be edited via click and drag row reordering.',
                    render: function(data, a, x, d, s) {
                        // console.log('d',d.row)
                        return '<div class="d-flex  justify-content-center " ><div  style="background-color: #F2F2F2; cursor: move" class="rounded"><span class="material-symbols-outlined">' +
                            'more_vert' +
                            '</span></div></div>';
                    }
                },

            ]
            const select = {
                style: 'multi',
                selector: 'td:first-child'
                // selector: 'td'
            }

            let drawCallback = function(a) {
                var api = this.api();
                $('#divImg').empty()
                $.each(api.data(), function(k, v) {
                    let loc = v?.city?.name + " - " + v?.item?.address + " - " + v?.item?.location;
                    let number = parseInt(v.index_number + 1)
                    $('#divImg').append(
                        '<div class="col-md-1 d-flex flex-column m-1" style="width: 150px; position: relative">' +
                        '<div class="bg-white d-flex justify-content-center" style="color: #4e28f7;position: absolute; border-radius: 100%; width: 20px; left: 17px; top: 5px; font-weight: bold">' +
                        number + '</div>' +
                        '<img src="' + v.item?.image2 + '" data-title="' + loc +
                        '" width="150" height="200" role="button" id="showImg">' +
                        '<span>' + loc + '</span>' +
                        '</div>');
                    // $(api.column(8)).html('1');
                    // console.log('$(api.column(8))', $(api.column(8)))
                })
                console.log('a.aoData', a.aoData)
                let lenght = a.aoData.length
                // $.each(a.aoData, function(k, v) {
                //     console.log('asdasd', )
                //     let divData = '<div class="h-full">';
                //     if (k == 0) {
                //         divData += '<div class="d-flex flex-column ">';
                //         divData += '<div></div>' +
                //             '<div><a class="btn btn-sm p-0" id="changeOrder" data-id="' + v._aData.id +
                //             '" data-number="' + v._aData.index_number +
                //             '" data-move="down" style="height: 15px"><span class="material-symbols-outlined iconsClass">arrow_drop_down</span></a></div>';
                //     } else if (parseInt(k + 1) == lenght) {
                //         divData += '<div class="d-flex flex-column ">';
                //         divData += '<div><a class="btn btn-sm p-0" id="changeOrder" data-id="' + v._aData.id +
                //             '" data-number="' + v._aData.index_number +
                //             '" data-move="up" style="height: 15px"><span class="material-symbols-outlined iconsClass">arrow_drop_up</span></a></div>' +
                //             '<div></div>';
                //
                //     } else {
                //         divData += '<div class="d-flex flex-column ">';
                //         divData += '<div><a class="btn btn-sm p-0" id="changeOrder" data-id="' + v._aData.id +
                //             '" data-number="' + v._aData.index_number +
                //             '" data-move="up" style="height: 15px"><span class="material-symbols-outlined iconsClass">arrow_drop_up</span></a></div>' +
                //             '<div><a class="btn btn-sm p-0" id="changeOrder" data-id="' + v._aData.id +
                //             '" data-number="' + v._aData.index_number +
                //             '" data-move="down" style="height: 15px"><span class="material-symbols-outlined iconsClass">arrow_drop_down</span></a></div>';
                //
                //     }
                //     divData += '</div></div>';
                //     v.anCells[8].innerHTML = divData
                // })
            }

            datatable('table_id', '{{ route('tambahproject.datatable', ['q' => request('q')]) }}', column, true,
                drawCallback, false, null, [], select, 'ltipr')

            $('#table_id').DataTable().on('row-reorder', function(e, diff, edit) {
                let result = edit.triggerRow.data();
                let id = result.id
                let number = result.index_number
                let newNumber = diff.filter(x => x.oldPosition === number)
                let move = newNumber[0]?.['newPosition']

                console.log('id', number)
                console.log('diff', diff)
                console.log('idnumber', )
                changeOrder(id, number, move)
                // for (var i = 0, ien = diff.length; i < ien; i++) {
                //     let rowData = table.row(diff[i].node).data();
                //
                //     result +=
                //         `${rowData[1]} updated to be in position ${diff[i].newData} ` +
                //         `(was ${diff[i].oldData})<br>`;
                // }
                //
                // document.querySelector('#result').innerHTML = 'Event result:<br>' + result;
            });
        }

        $(document).on('click', '#changeOrder', function() {
            let id = $(this).data('id')
            let number = $(this).data('number')
            let move = $(this).data('move')
            let data = {
                id,
                number,
                move,
                '_token': '{{ csrf_token() }}'
            }
            $.post('{{ route('tambahproject.move') }}', data, function(res) {
                console.log('ressss', res);
                $('#table_id').DataTable().ajax.reload();
            })
        })

        function changeOrder(id, number, move) {
            let data = {
                id,
                number,
                move,
                '_token': '{{ csrf_token() }}'
            }
            $.post('{{ route('tambahproject.new.move') }}', data, function(res) {
                console.log('ressss', res);
                $('#table_id').DataTable().ajax.reload();
            })
        }

        $(document).on('click', '#deleteTitik', function() {
            let id = $(this).data('id');
            let data = {
                _token: '{{ csrf_token() }}',
                'project_id': '{{ request('q') }}'
            };
            deleteData(name, "/admin/project/addproject/delete/" + id, data, afterSaveTitik);
        })

        function showDatatableItem() {
            let column = [{
                "className": '',
                "orderable": false,
                "defaultContent": ''
            }, {
                "data": "image1",
                "name": "image1",
                render: function(data) {
                    return '<img src="' + data + '" width="100" height="100" />'
                }
            }, {
                "data": "city.name",
                "name": "city.name",

            }, {
                "data": "address",
                "name": "address",
                render: function(data, x, row) {
                    return '<div class="d-flex flex-column">' +
                        '<span>' + data + '</div>' +
                        '<span class="text-muted">' + row?.location + '</div>' +
                        '</div>'
                }
            }, {
                "data": "vendor_all.name",
                "name": "vendorAll.name"
            }, {
                "data": "width",
                "name": "width",
                render: (data) => {
                    return toFixedWithoutZeros(parseFloat(data), 2)
                }
            }, {
                "data": "height",
                "name": "height",
                render: (data) => {
                    return toFixedWithoutZeros(parseFloat(data), 2)
                }
            }, {
                "data": "type.name",
                "name": "type.name"
            }, {
                "data": "position",
                "name": "position"
            }, {
                data: "status_on_rent",
                name: "status_on_rent",
                render: function(data) {
                    if (data.includes('used until')) {
                        return '<span class="text-danger fw-bold">' + data + '</span>'
                    } else if (data.includes('will used')) {
                        return '<span class="text-warning fw-bold">' + data + '</span>'
                    } else {
                        return '<span class="text-success fw-bold">' + data + '</span>'
                    }
                }
            }, {
                "data": "id",
                searchable: false,
                "render": function(data, type, row) {
                    const phone = row.vendor_all?.picPhone;
                    const text = 'Apakah ' + row['type']['name'] + ' yang berlokasi di ' + row['city']['name'] +
                        ' ' + row['address'] + ' ' + row['location'] + ' tersedia ?';

                    return "<div class='d-flex gap-2'>" +
                        "       <a class='btn-utama-soft sml rnd me-1' data-id='" + data +
                        "' id='detailData'> <i class='material-symbols-outlined menu-icon'>map</i></a>\n" +
                        "       <a class='btn-utama-soft sml rnd me-1'  data-phone='" + phone +
                        "' data-text='" + text +
                        "' id='detailDataWa'> <img src='{{ asset('/images/whatsapp.svg') }}' width='25'>\n" +
                        "<a data-id='" + row.id + "' data-vendor='" + row.vendor_all.name + "' data-kotaid='" +
                        row?.city_id + "' data-kota='" + row
                        ?.city?.name + "' data-rent_status='" + row?.status_on_rent + "' data-type='" + row
                        ?.type?.name + "' data-width='" + row.width +
                        "' data-height='" + row.height + "' data-location='" + row.location +
                        "' class='btn-utama sml rnd  me-1'" +
                        "  id='addItem'> <i class='material-symbols-outlined menu-icon text-white'>arrow_right_alt</i></a>\n" +
                        "</div>"
                }
            }, ]

            let drawCallback = function() {
                var api = this.api();
                console.log('323333', api)
            }
            console.log('urlTitikurlTitik', urlTitik)
            datatable('tambahtitik', urlTitik, column, true, drawCallback)

        }

        $(document).on('click', '#addItem', function() {
            let row = $(this).data()
            // if (row.rent_status.includes('used until')){
            //     swal(row?.type+" sudah digunakan")
            //     return false;
            // }
            $('#idTitik').val(row.id);
            $('#city_id').val(row.kotaid);
            $('#kota').val(row.kota);
            $('#alamat').val(row.location);
            $('#tinggi').val(row.height);
            $('#lebar').val(row.width);
            $('#tipe').val(row.type);
            $('#nama_vendor').val(row.vendor);
        })

        function changeData(a) {
            console.log('asdasd', $(a).val())
        }

        $(document).on('click', '#mapData, #addDataTitik', function() {
            let row = $(this).data()
            // $('#inp_namapic').val(row?.picnama)
            $('#formTitik #id').val(row?.id)
            $('#idPic').val(row?.pic_id)

            $('#idTitik').val(row?.itemid);
            $('#city_id').val(row?.kotaid);
            $('#kota').val(row?.kota);
            $('#alamat').val(row?.lokasi);
            $('#tinggi').val(row?.tinggi == "undefined" ? '' : row?.tinggi);
            $('#lebar').val(row?.lebar == "undefined" ? '' : row?.tinggi);
            $('#tipe').val(row?.tipe == "undefined" ? '' : row?.tipe);
            $('#inp_hargavendor').val(row?.harga);
            $("input[name=is_lighted][value='" + row.light + "']").prop("checked", true);
            let avail = row?.available
            $('#checkAvail').prop("checked", false);
            if (avail == "Tersedia") {
                $('#checkAvail').prop("checked", true);
                changeAvail()
            } else {
                changeAvail()
                $('#modaltambahtitik #date').val(avail)
            }
            getSelect("inp_namapic", "{{ route('user.get.json') }}", "nama", row?.pic_id, "Pilih PIC");
            let url = urlTitik;
            if (row?.kotaid) {
                url = url + '?city=' + row?.kotaid;
            }
            $('#tambahtitik').DataTable().ajax.url(url).load()

            $('#modaltambahtitik').modal('show')
        })

        function saveForm() {
            saveDataObjectFormData(
                "Simpan Data",
                $('#formProject').serialize(),
                "{{ route('project') }}",
                afterSaveProject
            );
            return false;
        }

        function afterSaveProject(res) {
            if (res.data) {
                window.location = '/admin/project/addproject?q=' + res.data;
            }
        }

        function saveFormPIC() {
            saveDataObjectFormData(
                "Simpan Data PIC",
                $('#formPIC').serialize(),
                "{{ route('tambahproject', ['q' => request('q')]) }}", afterSaveTitik
            );
            return false;
        }

        function saveTitik() {
            saveDataObjectFormData(
                "Simpan Data Titik",
                $('#formTitik').serialize(),
                "{{ route('tambahproject', ['q' => request('q')]) }}", afterSaveTitik
            );
            return false;
        }

        function afterSaveTitik() {
            $('#modaltambahtitik').modal('hide')
            $('#modaltambahpictitik').modal('hide')
            $('#table_id').DataTable().ajax.reload()
            getCountCity()
            getCountPIC()
        }

        $(document).on('click', '#detailDataWa', function() {
            let picPhone = $(this).data('phone');
            const first = picPhone.substring(0, 1);
            if (first == 0) {
                picPhone = '62' + picPhone.substring(1)
            }
            const text = encodeURI($(this).data('text'));
            $(this).attr('href', 'https://wa.me/' + picPhone + '?text=' + text).attr('target', '_blank')

        })
    </script>

    <script>
        function keyPressCallbackTitik(e) {
            $('#tambahtitik').DataTable().search(this.value).draw();
        }

        $(document).ajaxComplete(function(event, request, settings) {
            $("#tambahtitik_wrapper .dataTables_filter input")
                .unbind() // Unbind previous default bindings
                .bind("input", debounce(keyPressCallbackTitik, 1000));
        });

        function selectAll() {
            if ($('.selectalltable').is(':checked')) {
                $('#table_id').DataTable().rows().select();

            } else {
                $('#table_id').DataTable().rows().deselect();
            }
        }

        function showDatatableItemProject() {
            let column = [{
                "className": '',
                "orderable": false,
                "defaultContent": ''
            }, {
                "data": "name",
                "name": "name"
            }, {
                "data": "client_pic",
                "name": "client_pic"
            }, {
                "data": "duration",
                "render": function(data, type, row) {
                    return data + ' ' + row.duration_unit
                }
            }, {
                "data": "id",
                searchable: false,
                "render": function(data, type, row) {
                    return "<div class='d-flex gap-2'>" +
                        "<a data-id='" + row.id +
                        "' data-name='" + row.name +
                        "' class='btn-success sml rnd  me-1' id='addProject' >Masukan Dalam Project" +
                        "<i class='material-symbols-outlined menu-icon text-white'>arrow_right_alt</i></a>" +
                        "</div>"
                }
            }, ]
            datatable('tabelShare', '{{ route('project.datatable', ['n' => request('q')]) }}', column)

        }

        $(document).on('click', '#addProject', async function() {
            let data = $('#table_id').DataTable().rows({
                selected: true
            }).data();

            const name = $(this).data('name')
            let form = {
                'id': $(this).data('id'),
                '_token': '{{ csrf_token() }}',
                'item': []
            }
            await $.each(data, function(k, v) {
                form['item'][k] = v.id
            })
            if (form.item.length > 0) {
                saveDataObjectFormData(
                    "Gunakan item ke project " + name,
                    form,
                    "{{ route('clone.item') }}",
                    afterSaveProject
                );
            } else {
                swal("Silahkan pilih data yg akan di salin")
            }

            return false;
        })
    </script>
@endsection

@extends('admin.base')

@section('title')
    Tambah Project Yousee
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

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
                    <form id="formProject" onsubmit="return saveForm()">
                        @csrf
                        <input id="id" name="id" hidden>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="inp_nama" name="name" required value="{{$data ? $data->name : ""}}"
                                   placeholder="Nama Project">
                            <label for="inp_nama" class="form-label">Nama Project</label>
                        </div>

                        <div class="form-floating mb-3 nput-group date " id="datepicker" data-provide="datepicker">
                            <input type="text" class="form-control" id="date" name="request_date" required value="{{$data ? $data->request_date : ""}}"
                                   placeholder="Tanggal Request">
                            <label for="date" class="form-label">Tanggal Request</label>
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>

                        <div class="d-flex align-items-stretch mb-3 ">
                            <div class="form-floating me-1">
                                <input type="text" class="form-control" id="inp_durasi" name="duration" required value="{{$data ? $data->duration : ""}}"
                                       placeholder="Nama Tipe">
                                <label for="inp_durasi" class="form-label">Durasi</label>
                            </div>
                            <select class="form-select" aria-label="Default select example" id="duration_unit" name="duration_unit">
                                <option selected>Pilih Durasi</option>
                                <option value="day">Hari</option>
                                <option value="week">Minggu</option>
                                <option value="week">Bulan</option>
                                <option value="year">Tahun</option>
                            </select>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="inp_budget" name="inp_budget" required
                                   placeholder="Nama Tipe">
                            <label for="inp_budget" class="form-label">Budget</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="inp_pic_client" name="client_pic" required value="{{$data ? $data->client_pic : ""}}"
                                   placeholder="Nama PIC">
                            <label for="inp_budget" class="form-label">PIC Client</label>
                        </div>

                        <div class="mb-3 ">
                            <label for="inp_berlampu" class="form-label">Berlampu</label>
                            <div class="d-flex">
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="radio" name="is_lighted" value="1" id="inp_berlampu_ya">
                                    <label class="form-check-label" for="inp_berlampu_ya">
                                        Ya
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_lighted" value="0"
                                           id="inp_berlampu_tidak" checked>
                                    <label class="form-check-label" for="inp_berlampu_tidak">
                                        Tidak
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mb-3 ">
                            <textarea style="height: auto;" type="text" class="form-control" id="name" name="description" rows="10"
                                      required placeholder="Nama Tipe">{{$data ? $data->description : ""}}</textarea>
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
                            <a class="btn-success-soft sml rnd me-2" id="addPic">Tambah PIC titik<i
                                    class="material-symbols-outlined menu-icon ms-2 text-success">add_circle</i></a>

                            <a class="btn-utama-soft sml rnd "
                               id="addDataTitik">Tambah Titik <i
                                    class="material-symbols-outlined menu-icon ms-2 text-grey">arrow_right_alt</i></a>
                        </div>
                    </div>
                    <div class="isi">
                        <div class="table">
                            <table id="tbDetail" class="table table-striped" style="width:100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kota</th>
                                    <th>Lokasi titik</th>
                                    <th>PIC /titik</th>
                                    <th>Harga Vendor</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Kota</th>
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
                                    <table id="tambahtitik" class="table table-striped" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kota</th>
                                            <th>Alamat</th>
                                            <th>Vendor</th>
                                            <th>Lebar</th>
                                            <th>Tinggi</th>
                                            <th>Type</th>
                                            <th>Posisi</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Kota</th>
                                            <th>Alamat</th>
                                            <th>Vendor</th>
                                            <th>Lebar</th>
                                            <th>Tinggi</th>
                                            <th>Type</th>
                                            <th>Posisi</th>
                                            <th>Action</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="panel p-4">
                                    <form id="formTitik" onsubmit="return saveTitik()">
                                        @csrf
                                        <input id="id" name="id" hidden >
                                        <input id="idTitik" name="item_id" hidden>
                                        <input id="city_id" name="city_id" hidden>
                                        <input id="idTitik" name="action" value="titik" hidden>

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
                                            <input type="text" class="form-control" id="tinggi" name="tinggi"
                                                   placeholder="Tinggi" readonly>
                                            <label for="tinggi" class="form-label">Tinggi</label>
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
                                        <div class=" mb-3">
                                            <input id="idPic" name="idPic" hidden>
{{--                                            <input type="text" class="form-control" id="inp_namapic"--}}
{{--                                                   name="inp_namapic" required placeholder="Nama PIC">--}}
                                            <label for="inp_namapic" class="form-label">Nama PIC</label>
                                            <select id="inp_namapic" required name="pic_id" class="form-select " style="width: 100%"
                                                    aria-label="Default select example">
                                            </select>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control" id="inp_hargavendor"
                                                   name="vendor_price" required placeholder="Harga Vendor">
                                            <label for="inp_hargavendor" class="form-label">Harga Vendor</label>
                                        </div>

                                        <div class="my-3">
                                            <div class="d-flex">
                                                <button type="submit" class="btn-utama"
                                                        style="width: 100%">Simpan
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
                                    <select id="province" required name="province" class="form-select " style="width: 100%"
                                            aria-label="Default select example">
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="city" class="form-label">Pilih Kota</label>
                                    <select id="city" required name="city_id" class="form-select " style="width: 100%"
                                            aria-label="Default select example">
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="pic_id" class="form-label">Nama PIC</label>
                                    <select id="pic_id" required name="pic_id" class="form-select " style="width: 100%"
                                            aria-label="Default select example">
                                    </select>
                                </div>
                                {{--                                <div class="form-floating mb-3">--}}
                                {{--                                    <input type="text" class="form-control" id="in_hargavendor" name="in_hargavendor"--}}
                                {{--                                        required placeholder="Harga Vendor">--}}
                                {{--                                    <label for="in_hargavendor" class="form-label">Harga Vendor</label>--}}
                                {{--                                </div>--}}

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
        let param, prov, pic_id;
        var urlTitik = "/data/item/datatable";

        $(document).ready(function () {
            param = '{{request('q')}}'
            $('#duration_unit').val('{{$data ? $data->duration_unit : ""}}')
            $('#project_id').val(param)
            $('#inp_berlampu_ya').prop('checked', '{{$data && $data->is_lighted == 1 ? true : false}}')
            $('#inp_berlampu_tidak').prop('checked', '{{$data && $data->is_lighted == 0 ? true : false}}')
            // $('#tambahtitik').DataTable();
            $('#titik').DataTable();
            console.log('asdas', param)
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

        });

        $(document).on('click', '#addPic', function () {
            console.log('asdasd')
            getSelect("province", "/data/province", "name", prov, "Pilih Provinsi");
            getSelect("pic_id", "{{route('user.get.json')}}", "nama", pic_id, "Pilih PIC");
            $('#modaltambahpictitik').modal('show')
        })

        $(function () {
            $('#datepicker').datepicker({
                format: 'dd/mm/yyyy',
                todayHighlight: 'TRUE',
                autoclose: true,
            });
        });

        $(document).on("change", "#province", function () {
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
                "className": '',
                "orderable": false,
                "defaultContent": ''
            },
                {
                    "data": "city.name",
                    "name": "city.name"
                },
                {
                    "data": "item.location",
                    "name": "item.location"
                },
                {
                    "data": "pic.nama",
                    "name": "pic.nama"
                },
                {
                    "data": "vendor_price",
                    "name": "vendor_price"
                },
                {
                    "data": "id",
                    searchable: false,
                    "render": function (data, type, row) {
                        console.log(row)
                        return "<div class='d-flex gap-2'>\n" +
                            "                                <a class='btn-success-soft sml rnd' data-id='" +
                            data + "'  id='editData'> <i class='material-symbols-outlined menu-icon'>edit</i></a>" + "                               " +
                            " <a class='btn-success-soft sml rnd' data-itemid='"+row?.item_id+"' data-tipe='"+row?.item?.type?.name+"' data-tinggi='"+row?.item?.height+"' data-lebar='"+row?.item?.width+"' data-lokasi='"+row?.item?.location+"' data-kotaid='"+row?.item?.city?.id+"' data-kota='"+row?.item?.city?.name+"' data-picnama='"+row?.pic?.nama+"' data-pic_id='"+row.pic_id+"' data-harga='"+row?.vendor_price+"' data-id='" + data + "'  id='mapData'> <i class='material-symbols-outlined menu-icon'>map</i></a>" +
                            " <a class='btn-danger sml rnd  me-1' href='project/addproject' id='addData'> <i" +
                            "    class='material-symbols-outlined menu-icon text-white'>delete</i></a>" +
                            "</div>";
                    }
                },
            ]
            datatable('tbDetail', '{{route('tambahproject.datatable',['q' => request('q')])}}', column)
        }

        function showDatatableItem() {
            let column = [
                {
                    "className": '',
                    "orderable": false,
                    "defaultContent": ''
                }, {
                    "data": "city.name",
                    "name": "city.name"
                },{
                    "data": "location",
                    "name": "location"
                },{
                    "data": "vendor_all.name",
                    "name": "vendor_all.name"
                },{
                    "data": "width",
                    "name": "width"
                },{
                    "data": "height",
                    "name": "height"
                },{
                    "data": "type.name",
                    "name": "type.name"
                },{
                    "data": "position",
                    "name": "position"
                },{
                    "data": "id",
                    searchable: false,
                    "render": function (data, type, row) {
                        return "<div class='d-flex gap-2'>" +
                            "<a data-id='"+row.id+"' data-kotaid='" + row?.city?.id +"' data-kota='" + row?.city?.name +"' data-type='"+row?.type?.name+"' data-width='"+row.width+"' data-height='"+row.height+"' data-location='"+row.location+"' class='btn-utama sml rnd  me-1'" +
                            "  id='addItem'> <i class='material-symbols-outlined menu-icon text-white'>arrow_right_alt</i></a>\n" +
                            "</div>"
                    }
                },
            ]
            datatable('tambahtitik', urlTitik, column)

        }

        $(document).on('click','#addItem', function () {
            let row = $(this).data()
            console.log('asdadas', row)
            $('#idTitik').val(row.id);
            $('#city_id').val(row.kotaid);
            $('#kota').val(row.kota);
            $('#alamat').val(row.location);
            $('#tinggi').val(row.height);
            $('#lebar').val(row.width);
            $('#tipe').val(row.type);
        })

        $(document).on('click', '#mapData, #addDataTitik', function () {
            let row = $(this).data()
            console.log('asd', row)
            // $('#inp_namapic').val(row?.picnama)
            $('#formTitik #id').val(row?.id)
            $('#idPic').val(row?.pic_id)

            $('#idTitik').val(row.itemid);
            $('#city_id').val(row.kotaid);
            $('#kota').val(row.kota);
            $('#alamat').val(row.lokasi);
            $('#tinggi').val(row.tinggi);
            $('#lebar').val(row.lebar);
            $('#tipe').val(row.tipe);
            $('#inp_hargavendor').val(row.harga);
            getSelect("inp_namapic", "{{route('user.get.json')}}", "nama", row?.pic_id, "Pilih PIC");
            $('#tambahtitik').DataTable().ajax.url(urlTitik).load()

            $('#modaltambahtitik').modal('show')
        })

        function saveForm() {
            saveDataObjectFormData(
                "Simpan Data",
                $('#formProject').serialize(),
                "{{route('project')}}"
            );
            return false;
        }

        function saveFormPIC() {
            saveDataObjectFormData(
                "Simpan Data PIC",
                $('#formPIC').serialize(),
                "{{route('tambahproject', ['q' => request('q')])}}"
            );
            return false;
        }

        function saveTitik() {
            saveDataObjectFormData(
                "Simpan Data Titik",
                $('#formTitik').serialize(),
                "{{route('tambahproject', ['q' => request('q')])}}", afterSaveTitik
            );
            return false;
        }

        function afterSaveTitik() {
            $('#modaltambahtitik').modal('hide')
            $('#tbDetail').DataTable().ajax.reload()
        }
    </script>
@endsection

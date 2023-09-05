@extends('admin.base')

@section('title')
    Tambah Project Yousee
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/project">Project</a></li>
            <li class="breadcrumb-item"><a href="/admin/project/detail">Detail Project</a></li>
            <li class="breadcrumb-item active" aria-current="page">Buat Harga</li>
        </ol>
    </nav>

    <div>
        <div class="panel mb-1">
            <div class="title">
                <p>Buat Harga</p>

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
                                <th>Harga Jual</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Kota</td>
                                <td>Lokasi titik</td>
                                <td>PIC /titik</td>
                                <td>Harga Vendor</td>
                                <td>
                                    <input type="text" class="form-control" id="in_hargajual" name="in_hargajual"
                                        required placeholder="Harga Jual">
                                </td>
                                <td>
                                    <div class='d-flex'>
                                        <a class="btn-utama sml rnd  me-1" href="#">
                                            <i class='material-symbols-outlined menu-icon text-white'>save</i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Kota</td>
                                <td>Lokasi titik</td>
                                <td>PIC /titik</td>
                                <td>Harga Vendor</td>
                                <td>
                                    <input type="text" class="form-control" id="in_hargajual" name="in_hargajual"
                                        required placeholder="Harga Jual">
                                </td>
                                <td>
                                    <div class='d-flex'>
                                        <a class="btn-utama sml rnd  me-1" href="#">
                                            <i class='material-symbols-outlined menu-icon text-white'>save</i></a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Kota </th>
                                <th>Lokasi titik</th>
                                <th>PIC /titik</th>
                                <th>Harga Vendor</th>
                                <th>Harga Jual</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="pb-4 ps-4 pe-4 d-flex ">
                <a class="btn-utama-soft sml rnd me-2 ms-auto" data-bs-toggle="modal" data-bs-target="#modaltambahtitik"
                    id="addData">Simpan
                    (PDF)<i class="material-symbols-outlined menu-icon ms-2 text-prim">picture_as_pdf</i></a>

                <a class="btn-success-soft sml rnd " data-bs-toggle="modal" data-bs-target="#modaltambahtitik"
                    id="addData">Simpan
                    (Excel)<i class="material-symbols-outlined menu-icon ms-2 text-success">border_all</i></a>
            </div>
        </div>


    </div>
@endsection

@section('morejs')
    <script src="{{ asset('js/number_formater.js') }}"></script>

    <script>
        $(document).on('click', '#addData, #editData', function() {
            let id = $(this).data('id');
            let data = $(this).data('row');
            $('#form #name').val('');
            $('#form #id').val(id);


            $('#modaltambahtitik').modal('show')
        })




        function afterSave() {
            $('#modaltambahtitik').modal('hide')
            datatable();
        }
    </script>
@endsection

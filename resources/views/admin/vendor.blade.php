@extends('admin.base')

@section('title')
    Vendor
@endsection

@section('content')
    <div>

        <div class="panel">
            <div class="title">
                <p>Tipe Iklan</p>
                <a class="btn-utama-soft sml rnd " id="addData">Vendor Baru <i
                        class="material-icons menu-icon ms-2">add_circle</i></a>
            </div>

            <div class="isi">
                <div class="table">
                    <table id="table_id" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>No. Telp</th>
                                <th>Titik</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>No. Telp</th>
                                <th>Titik</th>
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
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modaltambahuser">Tambah Vendor Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form">
                            @csrf
                            <input id="id" name="id" hidden>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="name" name="name" required
                                    placeholder="Nama Tipe">
                                <label for="name" class="form-label">Nama Vendor</label>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea type="text" class="form-control" id="address" name="address" rows="5" required placeholder="Alamat Vendor"></textarea>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="phone" name="phone" required
                                    placeholder="Nomor Telepon">
                                <label for="notelp" class="form-label">No. Telp</label>
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
    @endsection

    @section('morejs')
        <script src="{{ asset('js/number_formater.js') }}"></script>

        <script>
            $(document).ready(function() {
                $('#table_piutang').DataTable();
                datatable();
                saveDataPage();
            });

            $(document).on('click', '#addData, #editData', function() {
                let id = $(this).data('id');
                let data = $(this).data('row');
                $('#form .form-control').val('');
                $('#form textarea').val('');
                $('#form #id').val(id);
                if (id){
                    $('#form #name').val(data.name);
                    $('#form #address').val(data.address);
                    $('#form #phone').val(data.phone);

                }

                $('#modaltambahtitik').modal('show')
            });

            function datatable() {
                var url = window.location.pathname+'/datatable';
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
                            "data": "name",
                            "name": "name"
                        },
                        {
                            "data": "address",
                            "name": "address"
                        },
                        {
                            "data": "phone",
                            "name": "phone"
                        },
                        {
                            "data": "item",
                            "name": "item"
                        },
                        {
                            "data": "id",
                            "render": function (data, type, row) {
                                let string = JSON.stringify(row);
                                return "<div class='d-flex'>\n" +
                                    "                                <a class='btn-success-soft sml rnd' data-id='" + data + "' data-row='" + string + "' id='editData'> <i class='material-icons menu-icon'>edit</i></a></div>";
                            }
                        },
                    ]
                });

            }

            function saveDataPage() {
                let form = $('#form');
                form.submit(async function (e) {
                    e.preventDefault(e);
                    let formData = new FormData(this);
                    console.log(formData);
                    let data = {
                        'form_data': formData,
                        'image': {
                            'icon': 'icon',
                        }
                    };
                    saveData('Simpan Data', 'form', window.location.pathname, afterSave);
                    return false;
                })
            }

            function afterSave() {
                $('#modaltambahtitik').modal('hide')
                datatable();
            }
        </script>
    @endsection


    </body>

    </html>

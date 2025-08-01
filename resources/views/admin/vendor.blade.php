@extends('admin.base')

@section('title')
    Vendor
@endsection

@section('content')
    <div>

        <div class="panel">
            <div class="title">
                <p>Data Vendor</p>
                <a class="btn-utama-soft sml rnd " id="addData">Vendor Baru <i
                        class="material-symbols-outlined menu-icon ms-2">add_circle</i></a>
            </div>

            <div class="isi">
                <div class="table">
                    <table id="table_id" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama CV / PT</th>
                                <th>Brand Vendor</th>
                                <th>Alamat</th>
                                <th>Email</th>
                                <th>No. Telp</th>
                                <th>Nama PIC</th>
                                <th>Nomor PIC</th>
                                <th>Titik</th>
                                <th>Apps</th>
                                <th>Terakhir Dilihat</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Nama CV / PT</th>
                                <th>Brand Vendor</th>
                                <th>Alamat</th>
                                <th>Email</th>
                                <th>No. Telp</th>
                                <th>Nama PIC</th>
                                <th>Nomor PIC</th>
                                <th>Titik</th>
                                <th>Apps</th>
                                <th>Terakhir Dilihat</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>

        <!-- Modal -->
        <div class="modal fade" id="modaltambahtitik" tabindex="-1" aria-labelledby="modaltambahtitik" aria-hidden="true">
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
                                <label for="name" class="form-label">Nama CV / PT</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="brand" name="brand" required
                                    placeholder="Nama Tipe">
                                <label for="brand" class="form-label">Brand</label>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea type="text" class="form-control" id="address" name="address" rows="5" required
                                    placeholder="Alamat Vendor"></textarea>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Nama Tipe">
                                <label for="email" class="form-label">Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="phone" name="phone" required
                                    placeholder="Nomor Telepon">
                                <label for="notelp" class="form-label">No. Telp Kantor</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="picName" name="picName" required
                                    placeholder="Nama Tipe">
                                <label for="picName" class="form-label">Nama PIC</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="picPhone" name="picPhone" required
                                    placeholder="Nama Tipe">
                                <label for="picPhone" class="form-label">Nomor PIC</label>
                                <span class="text-danger" style="font-size: 8pt">Gunakan tanda / (garis miring) untuk
                                    memisah nomor whatsapp</span>
                            </div>
                            <div class="mb-3" style="width: 100%; border-bottom: 1px solid #dee2d6"></div>
                            <span class="" style="font-size: 8pt">Password digunakan untuk login applikasi
                                vendor</span>
                            <div id="divPassword" class="mb-3 d-flex gap-2" style="align-items: center">
                                <div class="form-floating flex-1" style="width: 100%">
                                    <input type="password" class="form-control formData " id="password" name="password"
                                        placeholder="Jhony">
                                    <label for="password" class="form-label">Password</label>
                                </div>
                                <span role="button" onclick="showPass(this,'password' )"
                                    class="material-symbols-outlined">visibility_off</span>
                            </div>
                            <div id="divPasswordKon" class="mb-3 d-flex gap-2" style="align-items: center">
                                <div class="form-floating flex-1" style="width: 100%">
                                    <input type="password" class="form-control formData " id="password_confirmation"
                                        name="password_confirmation" placeholder="Jhony">
                                    <label for="password" class="form-label">Ulangi Password</label>
                                </div>
                                <span role="button" onclick="showPass(this,'password_confirmation' )"
                                    class="material-symbols-outlined">visibility_off</span>
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

        function showPass(a, field) {
            console.log($('#' + field + ' input'))
            if ($(a).html() == 'visibility') {
                $(a).html('visibility_off')
                $('#' + field).get(0).type = 'password'
            } else {
                $(a).html('visibility')
                $('#' + field).get(0).type = 'text'
            }
        }

        $(document).on('click', '#addData, #editData', function() {
            let id = $(this).data('id');
            let data = $(this).data('row');
            $('#form .form-control').val('');
            $('#form textarea').val('');
            $('#form #id').val(id);
            if (id) {
                $('#form #name').val(data.name);
                $('#form #address').val(data.address);
                $('#form #phone').val(data.phone);
                $('#form #brand').val(data.brand);
                $('#form #email').val(data.email);
                $('#form #picName').val(data.picName);
                $('#form #picPhone').val(data.picPhone);

            }

            $('#modaltambahtitik').modal('show')
        });

        $(document).on('click', '#deleteData', function() {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let data = {
                '_token': '{{ csrf_token() }}'
            };
            deleteData(name, window.location.pathname + '/delete/' + id, data, datatable);
            return false;
        })

        function datatable() {
            var url = window.location.pathname + '/datatable';
            $('#table_id').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: url,
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    // debugger;
                    var numStart = this.fnPagingInfo().iStart;
                    var index = numStart + iDisplayIndexFull + 1;
                    // var index = iDisplayIndexFull + 1;
                    $("td:first", nRow).html(index);
                    return nRow;
                },
                columns: [{
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
                        "data": "brand",
                        "name": "brand"
                    },
                    {
                        "data": "address",
                        "name": "address"
                    },
                    {
                        "data": "email",
                        "name": "email"
                    },
                    {
                        "data": "phone",
                        "name": "phone"
                    },
                    {
                        "data": "picName",
                        "name": "picName"
                    },
                    {
                        "data": "picPhone",
                        "name": "picPhone"
                    },
                    {
                        "data": "item",
                        "name": "item"
                    },
                    {
                        "data": "pass",
                        "name": "pass",
                        render: function(data) {
                            return data ?
                                '<span class="material-symbols-outlined text-success">expand_circle_down</span>' :
                                '<span class="material-symbols-outlined text-danger">do_not_disturb_on</span>'
                        }
                    },
                    {
                        "data": "last_seen",
                        "name": "last_seen",
                        render: function(data) {
                            return data ? toHumanDate(data) : ''
                            // return moment.duration('2024-02-05 20:01:36', "minutes").humanize()
                        }
                    },
                    {
                        "data": "id",
                        "render": function(data, type, row) {
                            let role = $('meta[name="role"]').attr('content');
                            var dlt = '';
                            if (role == 'pimpinan') {
                                dlt = "<a class='btn-danger-soft sml me-1' data-id='" + data +
                                    "' data-name='" + row.name +
                                    "' id='deleteData'> <i class='material-symbols-outlined menu-icon'>delete</i></a>";
                            }
                            let string = JSON.stringify(row);
                            return "<div class='d-flex'>\n" +
                                " <a class='btn-success-soft sml rnd me-1' data-id='" + data +
                                "' data-row='" +
                                string +
                                "' id='editData'> <i class='material-symbols-outlined menu-icon'>edit</i></a>" +
                                dlt + "</div>";
                        }
                    },
                ]
            });

        }

        function saveDataPage() {
            let form = $('#form');
            form.submit(async function(e) {
                e.preventDefault(e);
                let formData = new FormData(this);
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

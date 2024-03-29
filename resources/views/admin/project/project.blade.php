@extends('admin.base')

@section('title')
    Project Yousee
@endsection

@section('content')
    <div>


        <div class="panel">
            <div class="title">
                <p>Data Project</p>
                <a class="btn-utama-soft sml rnd " href="project/addproject" id="addData">Buat Project <i
                        class="material-symbols-outlined menu-icon ms-2">add_circle</i></a>
            </div>

            <div class="isi">
                <div class="table">
                    <table id="table_id" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Project</th>
                                <th>Tanggal Request</th>
                                <th>Jumlah Titik</th>
                                <th>PIC Client</th>
                                <th>Status</th>
                                <th>Durasi</th>
                                {{--                                <th>Status</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- <tr>
                            <td>#</td>
                            <td>Nama Project</td>
                            <td>Tanggal Request</td>
                            <td>Jumlah Titik</td>
                            <td>PIC Client</td>
                            <td>Durasi</td>
                            <th>Status</th>
                            <td>

                                <div class='d-flex'>
                                    <a class="btn-success sml rnd  me-1" href="/admin/project/detail/1" id="addData">
                                        <i class='material-symbols-outlined menu-icon text-white'>info</i></a>

                                    <a class="btn-utama sml rnd  me-1" href="/admin/project/detail/1"> <i
                                            class='material-symbols-outlined menu-icon text-white'>add</i></a>

                                    <a class="btn-danger sml rnd  me-1" href="project/addproject" id="addData"> <i
                                            class='material-symbols-outlined menu-icon text-white'>delete</i></a>

                                </div>
                            </td>
                        </tr> --}}
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Nama Project</th>
                                <th>Tanggal Request</th>
                                <th>Jumlah Titik</th>
                                <th>PIC Client</th>
                                <th>Status</th>
                                <th>Durasi</th>
                                {{--                                <th>Status</th> --}}
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>

        <!-- Modal -->
        {{-- <div class="modal fade" id="modaltambahtitik" tabindex="-1" aria-labelledby="modaltambahtitik" aria-hidden="true"> --}}
        {{-- <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltambahuser">Buat Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form" enctype="multipart/form-data">
                    @csrf
                    <input id="id" name="id" hidden>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="name" name="name" required
                            placeholder="Nama Tipe">
                        <label for="name" class="form-label">Nama Tipe</label>
                    </div>

                    <div class="mb-3">
                        <label for="icontipe" class="form-label">Icon Tipe</label>
                        {{-- <input class="form-control form-control-sm" id="icontipe" type="file"> --}}
        {{-- <input type="file" id="icon" name="" class="image" required data-min-height="10"
        accept="image/jpeg, image/jpg, image/png" data-allowed-file-extensions="jpg jpeg png" />
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
</div>  --}}
        <!-- Modal Detail-->

    </div>
@endsection

@section('morejs')
    <script src="{{ asset('js/number_formater.js') }}"></script>

    <script>
        $(document).ready(function() {
            datatable()
        });

        function datatable() {
            var url = '{{ route('project.datatable') }}';
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
                        "defaultContent": ''
                    },
                    {
                        "data": "name",
                        "name": "name"
                    },
                    {
                        "data": "request_date",
                        "name": "request_date"
                    },
                    {
                        "data": "items_count",
                        "name": "items_count"
                    },
                    {
                        "data": "client_pic",
                        "name": "client_pic"
                    },
                    {
                        "data": "status",
                        "render": function(data, type, row) {
                            return statusToString(row.status);
                        }
                    },
                    {
                        "data": "duration",
                        "render": function(data, type, row) {
                            return row.duration + " " + row.duration_unit;
                        }
                    },

                    {
                        "data": "id",
                        "render": function(data, type, row) {
                            let string = JSON.stringify(row);
                            return "<div class='d-flex gap-2'>\n" +
                                "<a class='btn-success sml rnd ' data-id='" +
                                data + "' data-row='" + string +
                                "' id='editData' href='/admin/project/addproject?q=" + row.id +
                                "'> <i class='material-symbols-outlined menu-icon text-white'>add</i></a>" +
                                // "<a class='btn-utama sml rnd  me-1' href='/admin/project/detail/" + row.id +
                                // "'>" +
                                // " <i class='material-symbols-outlined menu-icon text-white'>info</i></a>" +

                                "<div class='dropdown'>" +
                                "<a class='btn-warnings sml rnd  me-1'  data-bs-placement='top' title='Ganti Status'" +
                                "id='dropdownMenuButton" + row.id +
                                "' data-bs-toggle='dropdown' aria-expanded='false'>" +
                                " <i class='material-symbols-outlined menu-icon text-white'>stat_minus_1</i></a>" +
                                "<ul class='dropdown-menu' aria-labelledby='dropdownMenuButton" + row.id +
                                "'>'" +
                                "<a style= 'color: orange; padding: 0 10px; font-weight: bold; font-size: .7rem' >Ubah Status</a>" +
                                "<hr>" +
                                "<li><a class='dropdown-item' onclick='changestat(" + row.id +
                                ", 2, event)'>Sedang Tayang</a></li>" +
                                "<li><a class='dropdown-item' onclick='changestat(" + row.id +
                                ", 3, event)'>Selesai</a></li>" +
                                "<li><a class='dropdown-item  text-danger' onclick='changestat(" + row.id +
                                ", 4, event)'>Batal</a></li>" +
                                "</ul>" +
                                " </div>" +
                                "<a data-id='" + data +
                                "' class='btn-danger sml rnd  me-1' role='button' id='deleteProject'> <i" +
                                "    class='material-symbols-outlined menu-icon text-white'>delete</i></a>" +
                                "</div>";
                        }
                    },
                ]
            });
        }

        $(document).on('click', '#deleteProject', function() {
            let id = $(this).data('id');
            let data = {
                _token: '{{ csrf_token() }}',
            };
            deleteData(name, "/admin/project/delete/" + id, data, afterDelete);
        })

        function changestat(id, stat, e) {

            e.preventDefault();


            $.ajax({
                type: 'POST',
                url: "{{ route('changestatus') }}",
                timeout: 5000,
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id,
                    status: stat,
                },
                success: function(data) {
                    if (data == "gagal") {
                        alert(data);

                    }


                    // Assuming you've updated the DataTable's data
                    $('#table_id').DataTable().ajax.reload();
                },
                error: function(xhr, status, error) {
                    alert(error);

                }
            });
        }

        function afterDelete() {
            $('#table_id').DataTable().ajax.reload()
        }
    </script>
@endsection

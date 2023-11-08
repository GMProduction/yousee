@extends('admin.base')

@section('title')
    Tambah Project Yousee
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/project">Project</a></li>
            <li class="breadcrumb-item"><a href="/admin/project/detail/{{request('id')}}">Detail Project</a></li>
            <li class="breadcrumb-item active" aria-current="page">Buat Harga</li>
        </ol>
    </nav>

    <div>
        <div class="panel mb-1">
            <div class="title">
                <p>Buat Harga</p>
                <a class="btn-utama-soft sml rnd " id="openHargapaket">Masukan Harga Paket</a>
            </div>
            <div class="isi">
                <div class="table">
                    <table id="table_id" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tipe</th>
                                <th>Kota</th>
                                <th>Lokasi titik</th>
                                <th>PIC /titik</th>
                                <th>Harga Vendor</th>
                                <th>Harga Jual</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" style="text-align:center">Total Harga</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

           @if($data->to_name)
                <div class="pb-4 ps-4 pe-4 d-flex ">
                    <a class="btn-utama-soft sml rnd me-2 ms-auto" href="/admin/report/{{ request('id') }}" target="_blank"
                       id="addData">Simpan (PDF)<i
                            class="material-symbols-outlined menu-icon ms-2 text-prim">picture_as_pdf</i></a>

                    <a class="btn-success-soft sml rnd " href="{{ route('export.excell', ['id' => request('id')]) }}"
                       id="addData">Simpan (Excel)<i
                            class="material-symbols-outlined menu-icon ms-2 text-success">border_all</i></a>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Harga Paket -->
    <div class="modal fade" id="modalhargapaket" tabindex="-1" aria-labelledby="modalhargapaket" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modaltambahuser">Modal Harga Paket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="panel p-4">
                        <form id="formHaraga" onsubmit="return formSave()">
                            @csrf
                            <input name="type" hidden value="paket">
                            <div class="form-floating mb-3">
                                <input type="text"  class="form-control price" id="inp_harga1" name="price"
                                    placeholder="Total Harga Jual">
                                <label for="inp_hargapaket" class="form-label">Harga Paket</label>
                            </div>
                            <div class="my-3">
                                <div class="d-flex">
                                    <button type="submit" class="btn-utama" style="width: 100%">Simpan Harga Paket</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('morejs')
    <script src="{{ asset('js/number_formater.js') }}"></script>
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script src="{{ asset('js/currency.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.13.6/api/sum().js"></script>

    <script>
        let totalHarga = '{{ $data->total_price }}',
            totalHargaTable = 0;
        $(document).ready(function() {
            showData();
        });

        $(document).on('click', '#addData, #editData', function() {
            let id = $(this).data('id');
            let data = $(this).data('row');
            $('#form #name').val('');
            $('#form #id').val(id);
            $('#modaltambahtitik').modal('show')
        })

        function afterSave() {
            $('#modaltambahtitik').modal('hide')
        }

        $(document).ajaxComplete(function(event, request, settings) {
            currencyClass('price')
        });

        function showData() {
            let column = [{
                    "className": '',
                    "orderable": false,
                    "defaultContent": ''
                },
                {
                    "data": "item.type.name",
                    "name": "item.type.name"
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
                    "name": "vendor_price",
                    "render": function(data) {
                        return 'Rp. ' + data.toLocaleString()
                    }
                },
                {
                    "data": "end_price",
                    searchable: false,
                    "render": function(data, type, row) {
                        let dis = totalHarga == 0 ? '' : 'disabled'
                        return '<input type="text" ' + dis + ' class="form-control price" value="' + (row.end_price)
                            .toLocaleString() + '" id="inp' + row.id + '" name="in_hargajual" \n' +
                            ' required placeholder="Harga Jual">'
                    }
                },
                {
                    "data": "id",
                    searchable: false,
                    "render": function(data, type, row) {
                        let btn = 'save';
                        if (totalHarga == 0 && row.end_price != 0) {
                            btn = 'edit';
                        }
                        return totalHarga == 0 ? "<div class='d-flex gap-2'>\n" +
                            "<a class='btn-utama sml rnd  me-1' href='#' data-id='" + data + "' id='btnSave'>\n" +
                            "   <i class='material-symbols-outlined menu-icon text-white'>" + btn + "</i></a>\n" +
                            "</div>" : "";
                    }
                },
            ]

            let drawCallback = function() {
                var api = this.api();
                $(api.column(5).footer()).html(
                    'Rp. ' + api.column(5, {
                        page: 'current'
                    }).data().sum().toLocaleString()
                );
                totalHargaTable = api.column(6).data().sum()
                $(api.column(6).footer()).html(
                    totalHarga == 0  ? 'Rp. ' + parseInt(totalHargaTable).toLocaleString() : 'Rp. ' +parseInt(totalHarga).toLocaleString()
                );
            }
            datatable('table_id', '{{ route('tambahproject.datatable', ['q' => request('id')]) }}', column, false,
                drawCallback, false)

        }

        $(document).on('click', '#btnSave', function() {
            let id = $(this).data('id');
            let price = $('#inp' + id).val()
            let form = {
                idD: id,
                price,
                '_token': '{{ csrf_token() }}'
            }
            confirmSave(form)
        })

        function confirmSave(form) {
            saveDataObjectFormData(
                "Simpan Harga",
                form,
                "{{ route('detail.harga.post', ['id' => request('id')]) }}", afterSaveTitik
            );
            return false
        }

        function formSave() {
            let form = $('#formHaraga').serialize()
            return confirmSave(form)
        }

        function afterSaveTitik(res) {
            if (res.data) {
                totalHarga = res.data.total_price
            }
            $('#table_id').DataTable().ajax.reload();
            $('#modalhargapaket').modal('hide')

        }

        $(document).on('click', '#openHargapaket', function() {
            if (totalHargaTable > 0) {
                swal("Harga per item sudah di set, untuk memasukkan harga paket silahkan hapus harga per item", {
                    icon: "info",
                    buttons: true,
                })
                return false
            }
            $('#modalhargapaket #inp_harga1').val(parseInt(totalHarga).toLocaleString())
            $('#modalhargapaket').modal('show')
        })
    </script>
@endsection

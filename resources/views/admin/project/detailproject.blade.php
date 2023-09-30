@extends('admin.base')

@section('title')
    Tambah Project Yousee
@endsection

@section('css')
    <link href="https://cdn.datatables.net/select/1.7.0/css/select.dataTables.min.css" rel="stylesheet" />
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/project">Project</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Project</li>
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
                            <input type="text" readonly class="form-control" id="inp_nama" name="inp_nama" required
                                placeholder="Nama Project" value="{{ $data->name }}">
                            <label for="inp_nama" class="form-label">Nama Project</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" readonly class="form-control" id="inp_tgl_req" name="inp_tgl_req" required
                                placeholder="Tanggal Request" value="{{ $data->request_date }}">
                            <label for="inp_tgl_req" class="form-label">Tanggal Request</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" readonly class="form-control" id="inp_durasi" name="inp_durasi" required
                                placeholder="Nama Tipe" value="{{ $data->duration . ' ' . $data->duration_unit }}">
                            <label for="inp_durasi" class="form-label">Durasi</label>
                        </div>


                        <div class="form-floating mb-3">
                            <input type="text" readonly class="form-control" id="inp_pic_client" name="inp_pic_client"
                                required placeholder="Nama PIC" value="{{ $data->client_pic }}">
                            <label for="inp_budget" class="form-label">PIC Client</label>
                        </div>


                        <div class="form-floating mb-3 ">
                            <textarea style="height: auto;" type="text" class="form-control" id="name" name="name" rows="10"
                                readonly placeholder="Nama Tipe">{{ $data->description }}</textarea>
                            <label for="name" class="form-label">Keterangan</label>
                        </div>

                    </form>
                </div>
            </div>
            <div class="col-8">
                <div class="panel mb-1">
                    <div class="title">
                        <p>Data Titik</p>
                        <div class="d-flex">
                            <a class="btn-success-soft sml rnd me-2" href="/admin/project/buatharga/1">Buat
                                Harga<i class="material-symbols-outlined menu-icon ms-2 text-success">receipt_long</i></a>
                            <a class="btn-utama-soft sml rnd " data-bs-toggle="modal" data-bs-target="#modaltambahtitik"
                                id="addData">Gunakan Titik Untuk Project Baru<i
                                    class="material-symbols-outlined menu-icon ms-2 text-prim">arrow_right_alt</i></a>
                        </div>
                    </div>
                    <div class="isi">
                        <div class="table">
                            <table id="table_titik" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="text-center">
                                                <input class="form-check-input selectalltable text-center" type="checkbox"
                                                    value="" onclick="selectAll()" id="flexCheckDefault">
                                            </div>
                                        </th>
                                        <th>#</th>
                                        <th>Kota</th>
                                        <th>Lokasi titik</th>
                                        <th>PIC /titik</th>
                                        <th>Harga Vendor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->items as $item)
                                        <tr>
                                            <td></td>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $item->city->name }}</td>
                                            <td>{{ $item->item->location }}</td>
                                            <td>{{ $item->pic->nama }}</td>
                                            <td>Rp. {{ 0 }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <th>#</th>
                                        <th>Kota</th>
                                        <th>Lokasi titik</th>
                                        <th>PIC /titik</th>
                                        <th>Harga Vendor</th>
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
                                @foreach ($groupedCity as $gc)
                                    <a>{{ $gc[0]->city->name }} : {{ count($gc) }},</a>
                                @endforeach

                            </div>

                            <div>
                                @foreach ($groupedPIC as $gp)
                                    <a>{{ $gp[0]->pic->nama }} : {{ count($gp) }},</a>
                                @endforeach
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('morejs')
    <script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>
    <script src="{{ asset('js/number_formater.js') }}"></script>
    <script>
        var tb_titik;

        $(document).ready(function() {
            tb_titik = $('#table_titik').DataTable({

                select: true,
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0
                }],
                select: {
                    style: 'multi',
                    selector: 'td:first-child'
                },
                order: [
                    [1, 'asc']
                ]
            });
        });

        function selectAll() {
            if ($('.selectalltable').is(':checked')) {
                // alert("selected");
                tb_titik.rows().select();

            } else {
                // alert("no");
                tb_titik.rows().deselect();

            }

        }
    </script>
@endsection

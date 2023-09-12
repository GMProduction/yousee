@extends('admin.base')

@section('title')
    Tambah Project Yousee
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
                                placeholder="Nama Project">
                            <label for="inp_nama" class="form-label">Nama Project</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" readonly class="form-control" id="inp_tgl_req" name="inp_tgl_req" required
                                placeholder="Tanggal Request">
                            <label for="inp_tgl_req" class="form-label">Tanggal Request</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" readonly class="form-control" id="inp_durasi" name="inp_durasi" required
                                placeholder="Nama Tipe">
                            <label for="inp_durasi" class="form-label">Durasi</label>
                        </div>


                        <div class="form-floating mb-3">
                            <input type="text" readonly class="form-control" id="inp_budget" name="inp_budget" required
                                placeholder="Nama Tipe">
                            <label for="inp_budget" class="form-label">Budget</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" readonly class="form-control" id="inp_pic_client" name="inp_pic_client"
                                required placeholder="Nama PIC">
                            <label for="inp_budget" class="form-label">PIC Client</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" readonly class="form-control" id="inp_berlampu" name="inp_berlampu"
                                required placeholder="Berlampu">
                            <label for="inp_berlampu" class="form-label">Berlampu</label>
                        </div>

                        <div class="form-floating mb-3 ">
                            <textarea style="height: auto;" type="text" class="form-control" id="name" name="name" rows="10"
                                readonly placeholder="Nama Tipe"></textarea>
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
                                        <th></th>
                                        <th>#</th>
                                        <th>Kota </th>
                                        <th>Lokasi titik</th>
                                        <th>PIC /titik</th>
                                        <th>Harga Vendor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td>1</td>
                                        <td>Kota</td>
                                        <td>Lokasi titik</td>
                                        <td>PIC /titik</td>
                                        <td>Harga Vendor</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>2</td>
                                        <td>Kota</td>
                                        <td>Lokasi titik</td>
                                        <td>PIC /titik</td>
                                        <td>Harga Vendor</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>3</td>
                                        <td>Kota</td>
                                        <td>Lokasi titik</td>
                                        <td>PIC /titik</td>
                                        <td>Harga Vendor</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>4</td>
                                        <td>Kota</td>
                                        <td>Lokasi titik</td>
                                        <td>PIC /titik</td>
                                        <td>Harga Vendor</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <th>#</th>
                                        <th>Kota </th>
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


    </div>
@endsection

@section('morejs')
    <script src="{{ asset('js/number_formater.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#table_titik').DataTable({
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0
                }],
                select: {
                    selector: 'td:first-child'
                },
                order: [
                    [1, 'asc']
                ]
            });
        });
    </script>
@endsection


</body>

</html>

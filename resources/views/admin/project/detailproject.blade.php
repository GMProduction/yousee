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
                            <table id="table_id" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kota </th>
                                        <th>Lokasi titik</th>
                                        <th>PIC /titik</th>
                                        <th>Harga Vendor</th>
                                        <th>Pilih</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <td>1</td>
                                    <td>Kota</td>
                                    <td>Lokasi titik</td>
                                    <td>PIC /titik</td>
                                    <td>Harga Vendor</td>
                                    <td>
                                        <input class="form-check-input" type="checkbox" value="">
                                    </td>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Kota </th>
                                        <th>Lokasi titik</th>
                                        <th>PIC /titik</th>
                                        <th>Harga Vendor</th>
                                        <th>Pilih</th>
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
        <div class="modal fade" id="modaltambahtitik" tabindex="-1" aria-labelledby="modaltambahtitik" aria-hidden="true">
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


</body>

</html>

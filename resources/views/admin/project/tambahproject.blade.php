@extends('admin.base')

@section('title')
    Tambah Project Yousee
@endsection

@section('content')
    <div>

        <div class="row">
            <div class="col-4">
                <div class="panel p-4">
                    <form id="form" enctype="multipart/form-data">
                        @csrf
                        <input id="id" name="id" hidden>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="inp_nama" name="inp_nama" required
                                placeholder="Nama Project">
                            <label for="inp_nama" class="form-label">Nama Project</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="inp_tgl_req" name="inp_tgl_req" required
                                placeholder="Tanggal Request">
                            <label for="inp_tgl_req" class="form-label">Tanggal Request</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="inp_durasi" name="inp_durasi" required
                                placeholder="Nama Tipe">
                            <label for="inp_durasi" class="form-label">Durasi</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="inp_budget" name="inp_budget" required
                                placeholder="Nama Tipe">
                            <label for="inp_budget" class="form-label">Budget</label>
                        </div>

                        <div class="mb-3">
                            <label for="inp_berlampu" class="form-label">Berlampu</label>
                            <div id="inp_berlampu" class="form-check">
                                <input class="form-check-input" type="radio" name="inp_berlampu_ya" id="inp_berlampu_ya">
                                <label class="form-check-label" for="inp_berlampu_ya">
                                    Ya
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="inp_berlampu_tidak"
                                    id="inp_berlampu_tidak" checked>
                                <label class="form-check-label" for="inp_berlampu_tidak">
                                    Tidak
                                </label>
                            </div>
                        </div>

                        <div class="form-floating mb-3 ">
                            <textarea style="height: auto;" type="text" class="form-control" id="name" name="name" rows="10"
                                required placeholder="Nama Tipe"></textarea>
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
                <div class="panel">
                    <div class="title">
                        <p>Data Titik</p>
                        <a class="btn-utama-soft sml rnd " id="addData">Tambah Titik <i
                                class="material-symbols-outlined menu-icon ms-2">add_circle</i></a>
                    </div>

                    <div class="isi">
                        <div class="table">
                            <table id="table_id" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Titik </th>
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
                                        <th>Titik </th>
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

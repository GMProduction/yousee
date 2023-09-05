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
                            </tr>
                        </thead>
                        <tbody>
                            <td>1</td>
                            <td>Kota</td>
                            <td>Lokasi titik</td>
                            <td>PIC /titik</td>
                            <td>Harga Vendor</td>
                            <td>Harga Jual</td>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Kota </th>
                                <th>Lokasi titik</th>
                                <th>PIC /titik</th>
                                <th>Harga Vendor</th>
                                <th>Harga Jual</th>
                            </tr>
                        </tfoot>
                    </table>
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

@if (isset($tabel))
    <div class="isi">
        <div class="table">
            <table id="table_presence" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>latitude</th>
                        <th>logitude</th>
                        <th>Area</th>
                        <th>Status Koordinat</th>
                        <th>Alamat</th>
                        <th>Panjang / Tinggi</th>
                        <th>Lebar</th>
                        <th>Type</th>
                        <th>Qty</th>
                        <th>Side</th>
                        <th>Posisi</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>latitude</th>
                        <th>logitude</th>
                        <th>Area</th>
                        <th>Status Koordinat</th>
                        <th>Alamat</th>
                        <th>Panjang / Tinggi</th>
                        <th>Lebar</th>
                        <th>Type</th>
                        <th>Qty</th>
                        <th>Side</th>
                        <th>Posisi</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@else
    <div class="isi">
        <div class="table">
            <table id="table_id" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>latitude</th>
                        <th>logitude</th>
                        <th>Area</th>
                        <th>Status Koordinat</th>
                        <th>Alamat</th>
                        <th>Vendor</th>
                        <th>Panjang / Tinggi</th>
                        <th>Lebar</th>
                        <th>Type</th>
                        <th>Posisi</th>
                        <th>Created By</th>
                        <th>Last Updated By</th>
                        <th>Status</th>
                        <th>Last Updated By Vendor</th>
                        <th>Show</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>latitude</th>
                        <th>logitude</th>
                        <th>Area</th>
                        <th>Status Koordinat</th>
                        <th>Alamat</th>
                        <th>Vendor</th>
                        <th>Panjang / Tinggi</th>
                        <th>Lebar</th>
                        <th>Type</th>
                        <th>Posisi</th>
                        <th>Created By</th>
                        <th>Last Updated By</th>
                        <th>Status</th>
                        <th>Last Updated By Vendor</th>
                        <th>Show</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endif

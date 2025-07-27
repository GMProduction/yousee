@extends('admin.base')

@section('title')
    Vendor
@endsection

@section('content')
    <div class="panel">
        <div class="title">
            <p>Data User Affiliate</p>
            <div class="mb-3">
                <label for="filter-status">Filter Status:</label>
                <select id="filter-status" class="form-control"
                    style="width: 200px; display: inline-block; margin-left: 10px;">
                    <option value="">Semua</option>
                    <option value="menunggu">Menunggu</option>
                    <option value="diterima">Diterima</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>

        </div>


        <div class="isi">
            <div class="table">
                <table id="datatable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Status</th>
                            <th>CV</th>
                            <th>Dibuat</th>
                            <th>Aksi 1</th>
                            <th>Aksi 2</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Data Affiliate</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_id">

                        <div class="mb-3">
                            <label for="edit_nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="edit_nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_nophone" class="form-label">No HP</label>
                            <input type="text" class="form-control" id="edit_nophone" name="nophone" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('morejs')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.useraffiliate.data') }}',
                data: function(d) {
                    d.status = $('#filter-status').val();
                }
            },
            columns: [{
                    data: 'nama'
                },
                {
                    data: 'email'
                },
                {
                    data: 'nophone'
                },
                {
                    data: 'status',
                    render: function(data) {
                        let colorClass = {
                            'menunggu': 'bg-purple-200 text-purple-800',
                            'diterima': 'bg-green-200 text-green-800',
                            'ditolak': 'bg-red-200 text-red-800'
                        } [data] || 'bg-gray-200';

                        return `<span class="px-2 py-1 text-sm rounded ${colorClass}">${data}</span>`;
                    }
                },
                {
                    data: 'file_upload',
                    orderable: false,
                    searchable: false,
                    render: function(cv) {
                        if (cv) {
                            return `<a href="{{ base_url() }}storage/${cv}" target="_blank" class="btn btn-sm btn-info">Lihat CV</a>`;
                        } else {
                            return `<span class="text-muted">Tidak ada CV</span>`;
                        }
                    }
                },
                {
                    data: 'created_at',
                    render: function(data) {
                        const options = {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        };
                        const tgl = new Date(data);
                        return tgl.toLocaleDateString('id-ID', options);
                    }
                },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function(id) {
                        return `
                            <button class="btn btn-sm btn-success" onclick="ubahStatus(${id}, 'diterima')">Terima</button>
                            <button class="btn btn-sm btn-secondary" onclick="ubahStatus(${id}, 'ditolak')">Tolak</button>
                        `;
                    }
                },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function(id, type, row) {
                        let nohp = row.nophone;
                        let nama = row.nama;
                        if (nohp.startsWith('0')) {
                            nohp = '62' + nohp.substring(1);
                        }

                        // Encode pesan WA
                        let message =
                            `Halo, saya admin dari Yousee Indonesia. Apakah benar ini dengan ${nama}? Kami ingin mengkonfirmasi ketersediaan Anda untuk program afiliasi.`;
                        let encodedMessage = encodeURIComponent(message);

                        return `
            <button class="btn btn-sm btn-warning" onclick="showEditModal(${id})">Edit</button>
            <button class="btn btn-sm btn-danger" onclick="hapusData(${id})">Hapus</button>
            <a href="https://wa.me/${nohp}?text=${encodedMessage}" target="_blank" class="btn btn-sm btn-success">WhatsApp</a>`;
                    }
                }

            ]
        });

        $('#filter-status').on('change', function() {
            table.ajax.reload();
        });

        function hapusData(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/useraffiliate/' + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            $('#datatable').DataTable().ajax.reload();
                            Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success');
                        },
                        error: function() {
                            Swal.fire('Gagal!', 'Terjadi kesalahan.', 'error');
                        }
                    });
                }
            });
        }

        function ubahStatus(id, status) {
            Swal.fire({
                title: 'Yakin ubah status ke "' + status + '"?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, ubah'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/useraffiliate/' + id + '/status',
                        type: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}',
                            status: status
                        },
                        success: function() {
                            $('#datatable').DataTable().ajax.reload();
                            Swal.fire('Berhasil!', 'Status diubah.', 'success');
                        },
                        error: function() {
                            Swal.fire('Gagal!', 'Terjadi kesalahan.', 'error');
                        }
                    });
                }
            });
        }

        function showEditModal(id) {
            $.get(`/admin/useraffiliate/${id}`, function(res) {
                $('#edit_id').val(res.id);
                $('#edit_nama').val(res.nama);
                $('#edit_email').val(res.email);
                $('#edit_nophone').val(res.nophone);
                $('#editModal').modal('show');
            }).fail(function() {
                Swal.fire('Gagal!', 'Tidak dapat mengambil data.', 'error');
            });
        }

        $('#editForm').submit(function(e) {
            e.preventDefault();
            const id = $('#edit_id').val();

            $.ajax({
                url: `/admin/useraffiliate/${id}`,
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    nama: $('#edit_nama').val(),
                    email: $('#edit_email').val(),
                    nophone: $('#edit_nophone').val()
                },
                success: function() {
                    $('#editModal').modal('hide');
                    table.ajax.reload();
                    Swal.fire('Berhasil!', 'Data berhasil diubah.', 'success');
                },
                error: function() {
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat mengubah.', 'error');
                }
            });
        });
    </script>
@endsection

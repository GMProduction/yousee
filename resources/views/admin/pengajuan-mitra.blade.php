@extends('admin.base')

@section('content')
    <div class="panel">
        <div class="title">
            <p>Daftar Calon Vendor</p>
        </div>
        <div class="isi">
            <div class="table">
                <table id="tableCalonVendor" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nama Perusahaan</th>
                            <th>Brand</th>
                            <th>Alamat</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>PIC</th>
                            <th>Nomor PIC</th>
                            <th>File Titik</th>
                            <th>Status</th>
                            <th>Aksi Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('morejs')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {
            const baseUrl = "{{ url('/') }}";

            const table = $('#tableCalonVendor').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.calon-vendor.data') }}',
                columns: [{
                        data: 'uuid',
                        name: 'uuid',
                        visible: false, // sembunyikan kolom
                        searchable: false
                    }, {
                        data: 'nama_perusahaan',
                        name: 'nama_perusahaan'
                    },
                    {
                        data: 'brand_vendor',
                        name: 'brand_vendor'
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'nophone',
                        name: 'nophone'
                    },
                    {
                        data: 'pic',
                        name: 'pic'
                    },
                    {
                        data: 'nomor_pic',
                        name: 'nomor_pic'
                    },
                    {
                        data: 'titik_file',
                        name: 'titik_file',
                        orderable: false,
                        searchable: false
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
                        data: 'aksi_status',
                        name: 'aksi_status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'aksi_lainnya',
                        name: 'aksi_lainnya',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Aksi tombol
            $(document).on('click', '.btn-aksi', function() {
                const id = $(this).data('id');
                const aksi = $(this).data('aksi');

                if (aksi === 'whatsapp') {
                    const url = `{{ base_url() }}daftar_mitra/${id}`;
                    const message = encodeURIComponent(
                        "halo saya dari yousee indonesia, tolong isi pendaftaran lebih lanjut dengan mengisi form ini: " +
                        url);
                    window.open(`https://wa.me/?text=${message}`, '_blank');

                } else if (aksi === 'hapus') {
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Data yang dihapus tidak bisa dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `/admin/calon-vendor/${id}/delete`,
                                method: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    Swal.fire('Berhasil!', response.message, 'success');
                                    table.ajax.reload();
                                },
                                error: function(xhr) {
                                    Swal.fire('Gagal', xhr.responseJSON?.message ||
                                        'Terjadi kesalahan', 'error');
                                }
                            });
                        }
                    });
                } else if (aksi === 'terima' || aksi === 'tolak') {
                    const statusBaru = aksi === 'terima' ? 'diterima' : 'ditolak';
                    Swal.fire({
                        title: `Yakin ingin ${statusBaru}?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#aaa',
                        confirmButtonText: `Ya, ${statusBaru}`
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.post(`${baseUrl}/admin/calon-vendor/${id}/update-status`, {
                                _token: '{{ csrf_token() }}',
                                status: statusBaru
                            }, function() {
                                Swal.fire('Berhasil',
                                    `Status berhasil diubah menjadi ${statusBaru}.`,
                                    'success');
                                table.ajax.reload();
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection

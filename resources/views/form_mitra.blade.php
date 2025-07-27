<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Form Pengajuan Mitra</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5 mb-5">
        <h3 class="mb-4 text-center">Form Pengajuan Mitra</h3>

        <form action="{{ route('mitra.store') }}" method="POST" enctype="multipart/form-data"
            class="border p-4 rounded shadow-sm bg-light">
            @csrf

            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="name" id="name" placeholder="Nama CV / PT"
                    required>
                <label for="name">Nama CV / PT</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="brand" id="brand" placeholder="Brand Vendor"
                    required>
                <label for="brand">Brand Vendor</label>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Alamat</label>
                <textarea class="form-control" name="address" id="address" rows="3" required></textarea>
            </div>

            <div class="form-floating mb-3">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                <label for="email">Email</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="phone" id="phone" placeholder="No. Telp"
                    required>
                <label for="phone">No. Telp Kantor</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="pic_name" id="pic_name" placeholder="Nama PIC"
                    required>
                <label for="pic_name">Nama PIC</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="pic_phone" id="pic_phone" placeholder="Nomor PIC"
                    required>
                <label for="pic_phone">Nomor PIC</label>
            </div>

            <div class="mb-4">
                <label for="titik_file" class="form-label">Upload Titik Lokasi (PDF / Excel)</label>
                <input type="file" class="form-control" name="titik_file" id="titik_file" accept=".pdf,.xls,.xlsx"
                    required>
                <small class="text-muted">File harus dalam format .pdf, .xls, atau .xlsx</small>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS (opsional, hanya jika pakai interaksi JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

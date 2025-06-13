<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

    <h2 class="mb-4">Tambah Produk</h2>

    <form method="POST" action="/products" class="border p-4 rounded shadow-sm bg-light">
        @csrf
        <div class="mb-3">
            <input name="name" class="form-control" placeholder="Nama Produk">
        </div>
        <div class="mb-3">
            <input name="price" class="form-control" placeholder="Harga" type="number">
        </div>
        <div class="mb-3">
            <textarea name="description" class="form-control" placeholder="Deskripsi"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>

</body>
</html>

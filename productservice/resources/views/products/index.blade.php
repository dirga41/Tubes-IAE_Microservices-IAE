<!DOCTYPE html>
<html>
<head>
    <title>Daftar Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Produk</h2>
        <a href="/products/create" class="btn btn-success">+ Tambah Produk</a>
    </div>

    <ul class="list-group">
        @foreach($products as $product)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $product->name }}</strong> - Rp{{ number_format($product->price, 0, ',', '.') }}
                </div>
                <div class="d-flex gap-2">
                    <a href="/products/{{ $product->id }}/edit" class="btn btn-sm btn-warning">Edit</a>
                    <form action="/products/{{ $product->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                    <a href="/products/orders/{{ $product->id }}" class="btn btn-sm btn-info">Riwayat Order</a>
                </div>
            </li>
        @endforeach
    </ul>

</body>
</html>

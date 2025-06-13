<!DOCTYPE html>
<html>
<head>
    <title>Form Pembelian Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

    <h2 class="mb-4">Form Pembelian Produk</h2>

    <form method="POST" action="/orders" class="border p-4 rounded shadow-sm bg-light">
        @csrf

        <div class="mb-3">
            <label class="form-label">User:</label>
            <select name="user_id" class="form-select">
                @foreach($users as $user)
                    <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Produk:</label>
            <select name="product_id" class="form-select">
                @foreach($products as $product)
                    <option value="{{ $product['id'] }}">{{ $product['name'] }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Jumlah:</label>
            <input type="number" name="quantity" min="1" value="1" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Beli</button>
    </form>

</body>
</html>

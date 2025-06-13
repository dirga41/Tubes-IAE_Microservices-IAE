<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

    <h2 class="mb-4">Edit Produk</h2>

    <form method="POST" action="/products/{{ $product->id }}" class="border p-4 rounded shadow-sm bg-light">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <input name="name" class="form-control" value="{{ $product->name }}">
        </div>
        <div class="mb-3">
            <input name="price" type="number" class="form-control" value="{{ $product->price }}">
        </div>
        <div class="mb-3">
            <textarea name="description" class="form-control">{{ $product->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-warning">Update</button>
    </form>

</body>
</html>

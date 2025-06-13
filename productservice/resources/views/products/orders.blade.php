<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Order Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

    <h2 class="mb-4">Riwayat Order untuk: <span class="text-primary">{{ $product->name }}</span></h2>

    <ul class="list-group">
        @foreach($orders as $order)
            <li class="list-group-item">
                Order ID: {{ $order['id'] }} | User ID: {{ $order['user_id'] }} | Qty: {{ $order['quantity'] }}
            </li>
        @endforeach
    </ul>

</body>
</html>

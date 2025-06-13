<!DOCTYPE html>
<html>
<head>
    <title>History Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

    <h2 class="mb-4">History Order</h2>

    <ul class="list-group mb-4">
        @foreach($orders as $order)
            <li class="list-group-item">
                Order ID: {{ $order['id'] }} | Produk: {{ $order['product']['name'] ?? 'N/A' }} | Qty: {{ $order['quantity'] }}
            </li>
        @endforeach
    </ul>

    <a href="/dashboard" class="btn btn-secondary">Kembali ke Dashboard</a>

</body>
</html>

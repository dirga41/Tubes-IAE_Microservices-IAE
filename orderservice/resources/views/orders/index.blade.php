<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Riwayat Order</h2>
        <a href="/orders/create" class="btn btn-success">+ Buat Order</a>
    </div>

    <ul class="list-group">
        @foreach($orders as $order)
            <li class="list-group-item">
                <strong>Order #{{ $order->id }}</strong> - User ID: {{ $order->user_id }} - Produk ID: {{ $order->product_id }}
                - Qty: {{ $order->quantity }} - Total: <span class="text-success">Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
            </li>
        @endforeach
    </ul>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

    <h2 class="mb-3">Dashboard</h2>

    <div class="card p-3 mb-4">
        <p class="mb-1"><strong>Selamat datang:</strong> {{ $user['name'] }}</p>
        <p class="mb-0"><strong>Email:</strong> {{ $user['email'] }}</p>
    </div>

    <a href="/orders/history/{{ $user['id'] }}" class="btn btn-info">Lihat Riwayat Order</a>

</body>
</html>

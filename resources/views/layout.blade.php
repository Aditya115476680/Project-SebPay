<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SebPay Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f2f2f2;
        }
        .sidebar {
            width: 230px;
            background-color: #4b0b0b;
            color: white;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px 0;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 20px;
            font-weight: 500;
        }
        .sidebar a.active, .sidebar a:hover {
            background-color: #660d0d;
            border-radius: 10px;
        }
        .content {
            margin-left: 240px;
            padding: 30px;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            width: 60px;
        }
        .logo h4 {
            margin-top: 10px;
            font-weight: bold;
            color: white;
        }
        .card {
            border: none;
            border-radius: 15px;
            color: white;
            text-align: center;
        }
        .card.total { background-color: #7c0f0f; }
        .card.in { background-color: #a91818; }
        .card.out { background-color: #4b0b0b; }
        .chart-box {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="SebPay Logo">
            <h4>SebPay</h4>
        </div>
        <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('topping.index') }}" class="{{ request()->is('topping*') ? 'active' : '' }}">Kelola Topping</a>
        <a href="{{ route('topping.in') }}" class="{{ request()->is('topping/in') ? 'active' : '' }}">Topping In</a>
        <a href="{{ route('topping.out') }}" class="{{ request()->is('topping/out') ? 'active' : '' }}">Topping Out</a>
        <a href="{{ route('transaksi.index') }}" class="{{ request()->is('transaksi') ? 'active' : '' }}">Transaksi</a>
        <a href="{{ route('riwayat.index') }}" class="{{ request()->is('riwayat') ? 'active' : '' }}">Riwayat</a>
        <a href="{{ route('logout') }}">Logout</a>
    </div>

    <div class="content">
        @yield('content')
    </div>

</body>
</html>

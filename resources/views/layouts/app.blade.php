<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <div class="bg-dark text-white p-3" style="width: 220px; min-height: 100vh;">
        <h4>Dashboard</h4>
        <ul class="nav flex-column">
            <li class="nav-item"><a href="{{ url('/sellers') }}" class="nav-link text-white">Penjual</a></li>
            <li class="nav-item"><a href="{{ url('/buyers') }}" class="nav-link text-white">Pembeli</a></li>
        </ul>
    </div>

    <!-- Konten -->
    <div class="flex-grow-1 p-4">
        @yield('content')
    </div>
</div>
</body>
</html>

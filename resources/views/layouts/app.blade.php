<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Catatan Keuangan UMKM')</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 24px auto; padding: 0 16px; }
        nav { display: flex; gap: 16px; align-items: center; padding-bottom: 12px; border-bottom: 1px solid #ccc; margin-bottom: 20px; }
        nav form { margin-left: auto; }
        label { display: block; margin-top: 12px; }
        input, select { width: 100%; max-width: 420px; padding: 8px; box-sizing: border-box; }
        button { margin-top: 16px; padding: 8px 16px; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        .error { color: #c00; font-size: 14px; }
        .success { background: #e6f4ea; color: #1e6b34; padding: 8px 12px; margin-bottom: 12px; }
        .danger { background: #fdecea; color: #a11; padding: 8px 12px; margin-bottom: 12px; }
        .inline { display: inline; }
        .inline button { margin-top: 0; }
    </style>
</head>
<body>
    @auth
        <nav>
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('categories.index') }}">Kategori</a>
            <a href="{{ route('products.index') }}">Produk</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="margin-top: 0">Keluar</button>
            </form>
        </nav>
    @endauth

    @if (session('success')) <div class="success">{{ session('success') }}</div> @endif
    @if (session('error')) <div class="danger">{{ session('error') }}</div> @endif

    @yield('content')
</body>
</html>
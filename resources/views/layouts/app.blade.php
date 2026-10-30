<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Catatan Keuangan UMKM')</title>
    <style>
        body { font-family: sans-serif; max-width: 420px; margin: 40px auto; padding: 0 16px; }
        label { display: block; margin-top: 12px; }
        input { width: 100%; padding: 8px; box-sizing: border-box; }
        button { margin-top: 16px; padding: 8px 16px; }
        .error { color: #c00; font-size: 14px; }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
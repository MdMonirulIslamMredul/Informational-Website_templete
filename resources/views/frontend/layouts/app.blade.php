@php
    $globalSetting = \App\Models\Setting::first();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $globalSetting->meta_title ?? 'Solar Website Template')</title>
    <meta name="description" content="@yield('meta_description', $globalSetting->meta_description ?? 'Solar service website template built with Laravel')">
    <meta name="keywords" content="@yield('meta_keywords', $globalSetting->seo_keywords ?? 'solar, renewable, laravel template')">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @if ($globalSetting?->favicon_path)
        <link rel="icon" href="{{ asset('storage/' . $globalSetting->favicon_path) }}">
    @endif
    <style>
        :root {
            --brand: #0f766e;
            --brand-2: #f59e0b;
            --ink: #0f172a;
            --bg: #f8fafc;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
            color: var(--ink);
        }

        .navbar {
            backdrop-filter: blur(8px);
            background: rgba(255, 255, 255, 0.88);
        }

        .hero-gradient {
            background: radial-gradient(circle at 20% 20%, #d1fae5 0%, #e0f2fe 35%, #f8fafc 100%);
        }

        .section-title {
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .card {
            border: 0;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(2, 6, 23, 0.08);
        }

        .card:hover {
            transform: translateY(-4px);
            transition: .25s ease;
        }

        footer {
            background: #0b1324;
            color: #cbd5e1;
        }
    </style>
    @stack('styles')
</head>

<body>
    @include('frontend.partials.navbar')

    @if (session('success'))
        <div class="container mt-3">
            <div class="alert alert-success">{{ session('success') }}</div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    @include('frontend.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            duration: 650
        });
    </script>
    @stack('scripts')
</body>

</html>

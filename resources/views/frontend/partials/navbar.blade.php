@php
    $navSetting = \App\Models\Setting::first();
@endphp
<nav class="navbar navbar-expand-lg sticky-top border-bottom">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            @if ($navSetting?->logo_path)
                <img src="{{ asset('storage/' . $navSetting->logo_path) }}" alt="Logo" height="34" class="me-2">
            @endif
            {{ $navSetting->site_name ?? 'SolarTech' }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"><span
                class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto gap-lg-2">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('services.index') }}">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('team.index') }}">Team</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('blogs.index') }}">Blog</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button"
                        data-bs-toggle="dropdown">Gallery</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('gallery.photos') }}">Photo Gallery</a></li>
                        <li><a class="dropdown-item" href="{{ route('gallery.videos') }}">Video Gallery</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{ route('contact.index') }}">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>

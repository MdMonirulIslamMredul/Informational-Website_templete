@extends('frontend.layouts.app')

@section('title', $setting->meta_title ?? 'Home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}">
    <style>
        /* Hero Slider: Full Viewport Continuous Track */
        .hero-slider {
            position: relative;
            overflow: hidden;
            background: #0f172a;
            height: 82vh;
            min-height: 560px;
        }

        @media (min-width: 992px) {
            .hero-slider {
                height: 100vh;
                min-height: 650px;
            }
        }

        .hero-swiper {
            width: 100%;
            height: 100%;
            position: relative;
            user-select: none;
            -webkit-user-select: none;
        }

        .hero-swiper .swiper-wrapper {
            height: 100%;
            display: flex;
        }

        .hero-swiper .swiper-slide {
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: stretch;
            background: #0f172a;
            height: 100% !important;
            width: 100%;
            flex-shrink: 0;
        }

        .hero-swiper .hero-slide-bg {
            position: absolute;
            top: -4%;
            left: -4%;
            width: 108%;
            height: 108%;
            background-size: cover;
            background-position: center;
            transform: scale(1);
            will-change: transform;
            z-index: 1;
        }

        /* Continuous Ken Burns zoom animation for as long as the slide is shown */
        .hero-swiper .swiper-slide-active .hero-slide-bg {
            animation: heroContinuousZoom 8s ease-out forwards;
        }

        .hero-swiper .swiper-slide:not(.swiper-slide-active) .hero-slide-bg {
            animation: none;
            transform: scale(1);
        }

        @keyframes heroContinuousZoom {
            0% {
                transform: scale(1);
            }
            100% {
                transform: scale(1.12);
            }
        }

        .hero-swiper .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, rgba(15, 23, 42, 0.80), rgba(15, 118, 110, 0.45));
            z-index: 2;
        }

        .hero-swiper .hero-content {
            position: relative;
            z-index: 3;
            color: #fff;
        }

        .hero-swiper .hero-slide-inner {
            padding-top: 5.5rem;
            padding-bottom: 3.5rem;
            position: relative;
            z-index: 3;
            width: 100%;
            height: 100%;
        }

        @media (min-width: 992px) {
            .hero-swiper .hero-slide-inner {
                padding-top: 5rem;
                padding-bottom: 2.5rem;
            }

            .hero-swiper .hero-content {
                margin-top: 0;
            }
        }

        /* Flawless Text & Button Entrance Animations */
        .hero-swiper .swiper-slide .hero-title {
            opacity: 0;
            transform: translateY(35px);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .hero-swiper .swiper-slide .hero-subtitle {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .hero-swiper .swiper-slide .hero-actions {
            opacity: 0;
            transform: translateY(25px);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .hero-swiper .swiper-slide-active .hero-title {
            opacity: 1;
            transform: translateY(0);
            transition-delay: 0.18s;
        }

        .hero-swiper .swiper-slide-active .hero-subtitle {
            opacity: 1;
            transform: translateY(0);
            transition-delay: 0.36s;
        }

        .hero-swiper .swiper-slide-active .hero-actions {
            opacity: 1;
            transform: translateY(0);
            transition-delay: 0.52s;
        }

        /* Navigation Arrows */
        .hero-swiper-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 3.25rem;
            height: 3.25rem;
            border-radius: 50%;
            background-color: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            cursor: pointer;
            z-index: 10;
            transition: all 0.25s ease;
            opacity: 0.75;
        }

        .hero-swiper-btn:hover {
            background-color: rgba(15, 23, 42, 0.9);
            border-color: rgba(255, 255, 255, 0.7);
            color: #ffffff;
            transform: translateY(-50%) scale(1.12);
            opacity: 1;
        }

        .hero-swiper-prev {
            left: 1.5rem;
        }

        .hero-swiper-next {
            right: 1.5rem;
        }

        @media (max-width: 768px) {
            .hero-swiper-btn {
                display: none;
            }
        }

        /* Custom Pagination */
        .hero-swiper-pagination {
            position: absolute;
            bottom: 2.2rem !important;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            z-index: 10;
        }

        .hero-swiper-pagination .swiper-pagination-bullet {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: transparent;
            border: 2px solid rgba(255, 255, 255, 0.75);
            opacity: 0.65;
            margin: 0 !important;
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            cursor: pointer;
        }

        .hero-swiper-pagination .swiper-pagination-bullet-active {
            width: 36px;
            border-radius: 12px;
            background-color: #f59e0b;
            border-color: #f59e0b;
            opacity: 1;
        }

        /* Autoplay Progress Line */
        .hero-autoplay-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: rgba(255, 255, 255, 0.15);
            z-index: 10;
        }

        .hero-autoplay-progress-fill {
            width: 0%;
            height: 100%;
            background: linear-gradient(90deg, #f59e0b, #fbbf24);
            box-shadow: 0 0 8px rgba(245, 158, 11, 0.6);
        }

        .hero-slider .btn-outline-light {
            --bs-btn-color: #ffffffb6;
            --bs-btn-border-color: rgba(255, 255, 255, 0.85);
            --bs-btn-hover-color: #0f172a;
            --bs-btn-hover-bg: #ffffff47;
            --bs-btn-hover-border-color: #ffffff;
            --bs-btn-active-color: #0f172a;
            --bs-btn-active-bg: #ffffff;
            --bs-btn-active-border-color: #ffffff;
            color: #ffffff;
        }

        .section-carousel .carousel-inner {
            overflow: hidden;
        }

        .section-carousel {
            overflow-x: clip;
        }

        .section-carousel .carousel-item {
            padding: 0 3rem;
        }

        .section-carousel .carousel-control-prev,
        .section-carousel .carousel-control-next {
            width: 3rem;
        }

        .section-carousel .carousel-control-prev-icon,
        .section-carousel .carousel-control-next-icon {
            background-color: rgba(15, 23, 42, 0.9);
            background-size: 1rem 1rem;
            border-radius: 999px;
            width: 2.5rem;
            height: 2.5rem;
        }

        .section-carousel .card {
            min-height: 100%;
        }

        .counter-section {
            position: relative;
        }

        .counter-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 1.8rem 1.4rem;
            text-align: center;
            box-shadow: 0 12px 30px rgba(2, 6, 23, 0.08);
            height: 100%;
        }

        .counter-icon {
            width: 72px;
            height: 72px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, rgba(15, 118, 110, 0.12), rgba(245, 158, 11, 0.14));
            color: var(--brand);
        }

        .counter-number {
            font-size: clamp(2.2rem, 4vw, 3.4rem);
            font-weight: 800;
            line-height: 1;
            margin-bottom: 0.4rem;
            color: var(--ink);
        }

        .counter-title {
            margin-bottom: 0;
            color: #475569;
            font-weight: 600;
        }

        .testimonial-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 12px 30px rgba(2, 6, 23, 0.08);
            padding: 1.5rem;
            height: 100%;
        }

        .testimonial-avatar {
            width: 64px;
            height: 64px;
            border-radius: 999px;
            object-fit: cover;
            border: 3px solid rgba(15, 118, 110, 0.15);
            background: #f8fafc;
        }

        .testimonial-stars {
            color: #f59e0b;
            letter-spacing: 1px;
        }

        .testimonial-message {
            color: #475569;
            line-height: 1.7;
            margin-bottom: 1rem;
        }

        .testimonial-name {
            margin-bottom: 0.15rem;
            font-weight: 700;
            color: var(--ink);
        }

        .testimonial-role {
            margin-bottom: 0;
            color: #64748b;
            font-size: 0.95rem;
        }

        .faq-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 12px 30px rgba(2, 6, 23, 0.08);
        }

        .faq-accordion .accordion-item {
            border: 0;
            border-radius: 14px;
            overflow: hidden;
            background: #f8fafc;
        }

        .faq-accordion .accordion-item+.accordion-item {
            margin-top: 0.85rem;
        }

        .faq-accordion .accordion-button {
            font-weight: 600;
            color: var(--ink);
            background: #f8fafc;
            box-shadow: none;
        }

        .faq-accordion .accordion-button:not(.collapsed) {
            color: var(--brand);
            background: #eefbf9;
        }

        .faq-accordion .accordion-body {
            color: #475569;
            line-height: 1.75;
        }

        @media (max-width: 991px) {
            .section-carousel .carousel-item {
                padding: 0 2rem;
            }
        }

        @media (max-width: 575px) {
            .section-carousel .carousel-item {
                padding: 0 1rem;
            }
        }

        /* Partners Infinity Carousel Marquee */
        .partners-infinity-section {
            background: #ffffff;
            border-top: 1px solid rgba(226, 232, 240, 0.8);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        }
        .partner-marquee-wrapper {
            width: 100%;
            overflow: hidden;
            position: relative;
            padding: 1.25rem 0;
            mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
            -webkit-mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
        }
        .partner-marquee-track {
            display: flex;
            width: max-content;
            user-select: none;
        }
        .partner-marquee-group {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 1.25rem;
            flex-shrink: 0;
            width: max-content;
            animation: partnerMarqueeScroll 32s linear infinite;
            padding-right: 1.25rem;
        }
        .partner-marquee-wrapper:hover .partner-marquee-group {
            animation-play-state: paused;
        }
        @keyframes partnerMarqueeScroll {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-100%);
            }
        }
        .partner-marquee-item {
            flex-shrink: 0;
        }
        .partner-marquee-card {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 190px;
            height: 80px;
            padding: 0.35rem 0.85rem;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            text-decoration: none;
            box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            color: #1e293b;
        }
        .partner-marquee-card:hover {
            transform: translateY(-3px) scale(1.02);
            border-color: #0284c7;
            box-shadow: 0 10px 20px rgba(2, 132, 199, 0.12);
            color: #0284c7;
        }
        .partner-marquee-img {
            max-height: 58px;
            max-width: 172px;
            width: auto;
            height: 100%;
            object-fit: contain;
            filter: grayscale(80%) opacity(0.85);
            transition: all 0.3s ease;
        }
        .partner-marquee-card:hover .partner-marquee-img {
            filter: grayscale(0%) opacity(1);
        }
        .partner-marquee-fallback {
            display: flex;
            align-items: center;
            font-weight: 700;
            font-size: 0.95rem;
            white-space: nowrap;
        }
        .partner-marquee-name {
            color: #334155;
            transition: color 0.2s ease;
        }
        .partner-marquee-card:hover .partner-marquee-name {
            color: #0284c7;
        }

        /* Dark mode adjustments */
        html[data-theme='dark'] .partners-infinity-section {
            background: #0b1329;
            border-color: #1e293b;
        }
        html[data-theme='dark'] .partner-marquee-card {
            background: #0f172a;
            border-color: #1e293b;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
            color: #f1f5f9;
        }
        html[data-theme='dark'] .partner-marquee-card:hover {
            border-color: #38bdf8;
            box-shadow: 0 12px 24px rgba(56, 189, 248, 0.2);
        }
        html[data-theme='dark'] .partner-marquee-name {
            color: #f1f5f9;
        }
        html[data-theme='dark'] .partner-marquee-img {
            filter: brightness(0.9) grayscale(70%);
        }
        html[data-theme='dark'] .partner-marquee-card:hover .partner-marquee-img {
            filter: brightness(1) grayscale(0%);
        }
    </style>
@endpush

@section('content')
    @php
        $fallbackSlides = [
            [
                'title' => 'Future-Ready Solar Energy Solutions',
                'subtitle' =>
                    'We design, install, and maintain high-performance solar systems for homes and businesses.',
                'image' =>
                    'https://images.unsplash.com/photo-1509391366360-2e959784a276?auto=format&fit=crop&w=1600&q=80',
            ],
            [
                'title' => 'Smart Solar Installations For Every Roof',
                'subtitle' =>
                    'From residential rooftops to large commercial sites, we deliver engineered systems built to last.',
                'image' =>
                    'https://images.unsplash.com/photo-1592833159155-c62df1b65634?auto=format&fit=crop&w=1600&q=80',
            ],
            [
                'title' => 'Lower Bills, Cleaner Future',
                'subtitle' =>
                    'Switch to reliable renewable power and reduce electricity costs with full support from our experts.',
                'image' =>
                    'https://images.unsplash.com/photo-1611365892117-00e8f8f7bc9d?auto=format&fit=crop&w=1600&q=80',
            ],
        ];

        $heroSlides = collect($heroSlides ?? [])
            ->values()
            ->map(function ($slide, $index) use ($fallbackSlides) {
                $fallback = $fallbackSlides[$index] ?? end($fallbackSlides);

                return [
                    'title' => $slide->title ?: $fallback['title'],
                    'subtitle' => $slide->subtitle ?: $fallback['subtitle'],
                    'image' => !empty($slide->image) ? asset('storage/' . $slide->image) : $fallback['image'],
                ];
            });

        if ($heroSlides->isEmpty()) {
            $heroSlides = collect($fallbackSlides);
        }

        $serviceSlides = $services->chunk(3)->values();
        $productSlides = $products->chunk(3)->values();
        $activeCounters = collect($counters ?? []);
        $testimonialSlides = collect($testimonials ?? [])
            ->chunk(3)
            ->values();
        $faqItems = collect($faqs ?? []);
        $partnerItems = collect($partners ?? []);
    @endphp

    <section class="hero-slider">
        <div class="swiper hero-swiper">
            <div class="swiper-wrapper">
                @foreach ($heroSlides as $index => $slide)
                    <div class="swiper-slide">
                        <div class="hero-slide-bg" style="background-image: url('{{ $slide['image'] }}');"></div>
                        <div class="hero-overlay"></div>
                        <div class="container h-100 d-flex align-items-center hero-slide-inner">
                            <div class="hero-content col-lg-8">
                                <h1 class="display-4 fw-bold hero-title">{{ $slide['title'] }}</h1>
                                <p class="lead mb-4 hero-subtitle">{{ $slide['subtitle'] }}</p>
                                <div class="d-flex flex-wrap gap-2 hero-actions">
                                    <a href="{{ $setting->cta_button_link ?? route('contact.index') }}"
                                        class="btn btn-warning btn-lg">{{ $setting->cta_button_text ?? 'Get Consultation' }}</a>
                                    <a href="{{ route('services.index') }}" class="btn btn-outline-light btn-lg">Our
                                        Services</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Navigation Arrows --}}
            <button class="hero-swiper-btn hero-swiper-prev" type="button" aria-label="Previous Slide">
                <i class="bi bi-chevron-left"></i>
            </button>
            <button class="hero-swiper-btn hero-swiper-next" type="button" aria-label="Next Slide">
                <i class="bi bi-chevron-right"></i>
            </button>

            {{-- Pagination Dots --}}
            <div class="hero-swiper-pagination"></div>

            {{-- Autoplay Progress Line --}}
            <div class="hero-autoplay-progress">
                <div class="hero-autoplay-progress-fill"></div>
            </div>
        </div>
    </section>



    <section class="section-modern section-modern-light" id="about-section">
        @php
            $img1 = !empty($about?->image1)
                ? asset('storage/' . $about->image1)
                : 'https://images.unsplash.com/photo-1595273670150-bd0c3c392e46?auto=format&fit=crop&w=1000&q=80';
            $img2 = !empty($about?->image2)
                ? asset('storage/' . $about->image2)
                : 'https://images.unsplash.com/photo-1497436072909-60f360e1d4b1?auto=format&fit=crop&w=1200&q=80';

            $defaultValues = ['Craftsmanship', 'Innovation', 'Sustainability', 'Customer-Centric'];
            $keyValues = collect($about?->key_values ?? [])
                ->filter()
                ->values();
            if ($keyValues->isEmpty()) {
                $keyValues = collect($defaultValues);
            }

            $splitAt = (int) ceil($keyValues->count() / 2);
            $leftValues = $keyValues->slice(0, $splitAt);
            $rightValues = $keyValues->slice($splitAt);
        @endphp

        <div class="container">
            <div class="row gx-5 align-items-center about-row">
                <div class="col-lg-6" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="200">
                    <div class="about-image-wrap" style="position:relative;">
                        <img src="{{ $img1 }}" alt="About image" class="about-image">

                        <div class="experience-badge">
                            <div class="exp-number">{{ $about?->years_experience ?? 10 }} +
                            </div>
                            <div class="exp-text">Years Experience</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="300">
                    <div class="modern-card" style="padding: 2.5rem 2rem 1rem;">
                        <span class="section-subtitle-modern">About Us</span>
                        <h2 class="section-title-modern about-title">{{ $about?->title ?? 'Company Overview' }}</h2>
                        <div class="content-description-modern about-text" style="font-size: 1.05rem; line-height: 1.8;">
                            {!! $about?->page_details ??
                                '<p>We build reliable renewable energy systems with long-term performance in mind.</p>' !!}
                        </div>

                        <div class="key-values-card" style="background-image: url('{{ $img2 }}')">
                            <div class="kv-overlay">
                                <h4 class="kv-title">Our Key Values</h4>
                                <div class="row">
                                    <div class="col-6">
                                        <ul class="kv-items">
                                            @foreach ($leftValues as $value)
                                                <li><i class="bi bi-arrow-right-short"></i> {{ $value }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-6">
                                        <ul class="kv-items">
                                            @foreach ($rightValues as $value)
                                                <li><i class="bi bi-arrow-right-short"></i> {{ $value }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* About section custom styles */
        .about-image {
            width: 100%;
            height: auto;
            border-radius: 14px;
            display: block;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        }

        .experience-badge {
            position: absolute;
            bottom: -28px;
            left: 28px;
            background: rgba(123, 27, 27, 0.95);
            color: #fff;
            padding: 18px 26px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
            min-width: 190px;
        }

        .experience-badge .exp-number {
            font-size: 28px;
            font-weight: 700;
            line-height: 1;
        }

        .experience-badge .exp-text {
            font-size: 14px;
            opacity: 0.95;
            margin-top: 6px;
        }

        .about-title {
            color: #7b1b1b;
            font-size: 42px;
            margin-top: 8px;
            margin-bottom: 18px;
        }

        .key-values-card {
            margin-top: 28px;
            border-radius: 12px;
            overflow: hidden;
            background-size: cover;
            background-position: center;
            min-height: 170px;
            position: relative;
        }

        .key-values-card .kv-overlay {
            position: relative;
            z-index: 2;
            color: #fff;
            padding: 18px 22px;
        }

        .key-values-card::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.25));
        }

        .kv-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #fff;
        }

        .kv-items {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .kv-items li {
            color: #fff;
            padding: 6px 0;
            font-size: 15px;
        }

        .kv-items li i {
            margin-right: 8px;
        }

        /* Responsive adjustments */
        @media (max-width: 991px) {
            .experience-badge {
                position: relative;
                bottom: 0;
                left: 0;
                margin-top: 18px;
            }

            .about-title {
                font-size: 32px;
            }
        }
    </style>

    <section class="py-5">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-7" data-aos="fade-right">
                    <h2 class="section-title">Why Choose Us</h2>
                    <p class="text-secondary mb-0">Expert solar planning, precision installation, and long-term maintenance
                        to keep your power generation stable year-round.</p>
                </div>
                <div class="col-lg-5" data-aos="zoom-in">
                    <div class="card p-4">
                        <ul class="mb-0">
                            <li>Expert engineers and certified installers</li>
                            <li>End-to-end project management</li>
                            <li>Long-term maintenance support</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @if ($activeCounters->isNotEmpty())
        <section class="py-5 counter-section" data-aos="fade-up">
            <div class="container">
                <div class="text-center mb-4" data-aos="fade-up">
                    <span class="section-subtitle-modern">Our Success</span>
                    <h2 class="section-title-modern">We have a proven track record of success.</h2>
                </div>

                <div class="row g-4 justify-content-center">
                    @foreach ($activeCounters as $counter)
                        @php
                            $counterIconIsFile = $counter->icon && str_contains($counter->icon, '/');
                        @endphp
                        <div class="col-12 col-sm-6 col-lg-3" data-aos="zoom-in"
                            data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="counter-card">
                                <div class="counter-icon">
                                    @if ($counter->icon)
                                        @if ($counterIconIsFile)
                                            <img src="{{ asset('storage/' . $counter->icon) }}"
                                                alt="{{ $counter->title }}"
                                                style="width: 38px; height: 38px; object-fit: cover; border-radius: 10px;">
                                        @else
                                            <i class="bi {{ $counter->icon }}" style="font-size: 2rem;"></i>
                                        @endif
                                    @else
                                        <i class="bi bi-tools" style="font-size: 2rem;"></i>
                                    @endif
                                </div>
                                <div class="counter-number" data-counter-value="{{ $counter->value }}">0+</div>
                                <p class="counter-title">{{ $counter->title }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif



    <section class="py-5">
        <div class="container">
            <h2 class="section-title mb-4" data-aos="fade-up">Featured Services</h2>
            @if ($serviceSlides->isNotEmpty())
                <div id="featuredServicesCarousel" class="carousel slide section-carousel" data-bs-ride="carousel"
                    data-bs-interval="5000">
                    <div class="carousel-inner">
                        @foreach ($serviceSlides as $slideIndex => $serviceChunk)
                            <div class="carousel-item {{ $slideIndex === 0 ? 'active' : '' }}">
                                <div class="row g-4 justify-content-center">
                                    @foreach ($serviceChunk as $service)
                                        <div class="col-md-6 col-lg-4 d-flex" data-aos="fade-up">
                                            <div class="card h-100 p-3 w-100">
                                                @if ($service->image)
                                                    <img src="{{ asset('storage/' . $service->image) }}"
                                                        class="card-img-top mb-3 rounded" alt="{{ $service->title }}"
                                                        style="height: 180px; object-fit: cover;">
                                                @else
                                                    <div class="d-flex align-items-center justify-content-center bg-light rounded mb-3"
                                                        style="height: 180px;">
                                                        <i class="bi bi-tools text-secondary"
                                                            style="font-size: 4rem;"></i>
                                                    </div>
                                                @endif
                                                <h5>{{ $service->title }}</h5>
                                                <p class="text-secondary">{{ $service->short_description }}</p>
                                                <a href="{{ route('services.show', $service->slug) }}"
                                                    class="btn btn-outline-dark btn-sm mt-auto">View Details</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($serviceSlides->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#featuredServicesCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#featuredServicesCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    @endif
                </div>
            @else
                <div class="alert alert-light border mb-0">No services found.</div>
            @endif
        </div>
    </section>

    <section class="py-5 bg-white">
        <div class="container">
            <h2 class="section-title mb-4" data-aos="fade-up">Featured Products</h2>
            @if ($productSlides->isNotEmpty())
                <div id="featuredProductsCarousel" class="carousel slide section-carousel" data-bs-ride="carousel"
                    data-bs-interval="5000">
                    <div class="carousel-inner">
                        @foreach ($productSlides as $slideIndex => $productChunk)
                            <div class="carousel-item {{ $slideIndex === 0 ? 'active' : '' }}">
                                <div class="row g-4 justify-content-center">
                                    @foreach ($productChunk as $product)
                                        <div class="col-sm-6 col-lg-4 d-flex" data-aos="zoom-in">
                                            <div class="card h-100 w-100">
                                                @if ($product->image)
                                                    <img src="{{ asset('storage/' . $product->image) }}"
                                                        class="card-img-top" alt="{{ $product->title }}">
                                                @else
                                                    <div class="d-flex align-items-center justify-content-center bg-light rounded mb-3"
                                                        style="height: 180px;">
                                                        <i class="bi bi-box-seam text-secondary"
                                                            style="font-size: 4rem;"></i>
                                                    </div>
                                                    {{-- <span class="text-muted">No image</span> --}}
                                                @endif
                                                <div class="card-body d-flex flex-column">
                                                    <h6>{{ $product->title }}</h6>
                                                    <p class="small text-secondary">{{ $product->short_description }}</p>
                                                    <a href="{{ route('products.show', $product->slug) }}"
                                                        class="btn btn-outline-dark btn-sm mt-auto">Explore</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($productSlides->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#featuredProductsCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#featuredProductsCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    @endif
                </div>
            @else
                <div class="alert alert-light border mb-0">No products found.</div>
            @endif
        </div>
    </section>

    @if ($testimonialSlides->isNotEmpty())
        <section class="py-5">
            <div class="container">
                <div class="text-center mb-4" data-aos="fade-up">
                    <span class="section-subtitle-modern">Happy Customers</span>
                    <h2 class="section-title-modern">What clients are expressing about us.</h2>
                </div>

                <div id="testimonialCarousel" class="carousel slide section-carousel" data-bs-ride="carousel"
                    data-bs-interval="6000" data-bs-pause="false">
                    <div class="carousel-indicators">
                        @foreach ($testimonialSlides as $index => $testimonialChunk)
                            <button type="button" data-bs-target="#testimonialCarousel"
                                data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"
                                aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                                aria-label="Testimonial slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>

                    <div class="carousel-inner">
                        @foreach ($testimonialSlides as $slideIndex => $testimonialChunk)
                            <div class="carousel-item {{ $slideIndex === 0 ? 'active' : '' }}">
                                <div class="row g-4 justify-content-center">
                                    @foreach ($testimonialChunk as $testimonial)
                                        <div class="col-md-6 col-lg-4 d-flex" data-aos="fade-up">
                                            <div class="testimonial-card w-100">
                                                <div class="d-flex align-items-center gap-3 mb-3">
                                                    @if ($testimonial->image)
                                                        <img src="{{ asset('storage/' . $testimonial->image) }}"
                                                            alt="{{ $testimonial->name }}" class="testimonial-avatar">
                                                    @else
                                                        <div
                                                            class="testimonial-avatar d-flex align-items-center justify-content-center text-secondary">
                                                            <i class="bi bi-person-circle" style="font-size: 2rem;"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h5 class="testimonial-name">{{ $testimonial->name }}</h5>
                                                        <p class="testimonial-role">{{ $testimonial->designation }}</p>
                                                    </div>
                                                </div>

                                                <div class="testimonial-stars mb-3"
                                                    aria-label="{{ $testimonial->rating }} out of 5 stars">
                                                    @for ($star = 1; $star <= 5; $star++)
                                                        <i
                                                            class="bi {{ $star <= $testimonial->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                                    @endfor
                                                </div>

                                                <p class="testimonial-message mb-0">{{ $testimonial->message }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($testimonialSlides->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    @endif
                </div>
            </div>
        </section>
    @endif

    @if ($faqItems->isNotEmpty())
        <section class="py-5">
            <div class="container">
                <div class="text-center mb-4" data-aos="fade-up">
                    <span class="section-subtitle-modern">FAQ</span>
                    <h2 class="section-title-modern">Questions people ask before getting started.</h2>
                </div>

                <div class="faq-card p-3 p-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="accordion faq-accordion" id="homepageFaqAccordion">
                        @foreach ($faqItems as $faq)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqHeading{{ $faq->id }}">
                                    <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#faqCollapse{{ $faq->id }}"
                                        aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                        aria-controls="faqCollapse{{ $faq->id }}">
                                        {{ $faq->question }}
                                    </button>
                                </h2>
                                <div id="faqCollapse{{ $faq->id }}"
                                    class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                    aria-labelledby="faqHeading{{ $faq->id }}"
                                    data-bs-parent="#homepageFaqAccordion">
                                    <div class="accordion-body">
                                        {{ $faq->answer }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- PARTNERS INFINITY CAROUSEL SECTION --}}
    @php
        $partnerList = $partnerItems;
        if ($partnerList->isEmpty()) {
            $partnerList = collect([
                (object)[
                    'name' => 'SMA Solar Technology',
                    'image' => null,
                    'website_url' => 'https://www.sma.de/en',
                    'fallback_icon' => 'bi-sun-fill',
                    'fallback_color' => '#f59e0b',
                ],
                (object)[
                    'name' => 'Tesla Energy',
                    'image' => null,
                    'website_url' => 'https://www.tesla.com/energy',
                    'fallback_icon' => 'bi-lightning-charge-fill',
                    'fallback_color' => '#ef4444',
                ],
                (object)[
                    'name' => 'Siemens Renewable',
                    'image' => null,
                    'website_url' => 'https://www.siemens.com',
                    'fallback_icon' => 'bi-cpu-fill',
                    'fallback_color' => '#0d9488',
                ],
                (object)[
                    'name' => 'SunPower Systems',
                    'image' => null,
                    'website_url' => 'https://us.sunpower.com',
                    'fallback_icon' => 'bi-brightness-high-fill',
                    'fallback_color' => '#f97316',
                ],
                (object)[
                    'name' => 'Huawei Smart PV',
                    'image' => null,
                    'website_url' => 'https://solar.huawei.com',
                    'fallback_icon' => 'bi-router-fill',
                    'fallback_color' => '#dc2626',
                ],
                (object)[
                    'name' => 'Enphase Energy',
                    'image' => null,
                    'website_url' => 'https://enphase.com',
                    'fallback_icon' => 'bi-battery-charging',
                    'fallback_color' => '#0284c7',
                ],
                (object)[
                    'name' => 'Schneider Electric',
                    'image' => null,
                    'website_url' => 'https://www.se.com',
                    'fallback_icon' => 'bi-gear-wide-connected',
                    'fallback_color' => '#16a34a',
                ],
                (object)[
                    'name' => 'Canadian Solar',
                    'image' => null,
                    'website_url' => 'https://www.canadiansolar.com',
                    'fallback_icon' => 'bi-globe-americas',
                    'fallback_color' => '#b91c1c',
                ],
            ]);
        }

        // Multiply items if count is small so the seamless loop fills any screen width with compact spacing
        if ($partnerList->isNotEmpty() && $partnerList->count() < 12) {
            $multiplied = collect();
            while ($multiplied->count() < 12) {
                $multiplied = $multiplied->concat($partnerList);
            }
            $partnerList = $multiplied;
        }
    @endphp

    <section class="py-5 partners-infinity-section position-relative overflow-hidden">
        <div class="container mb-4 text-center" data-aos="fade-up">
            <span class="section-subtitle-modern">Strategic Alliances</span>
            <h2 class="section-title-modern">Trusted by Leading Technology & Industry Partners</h2>
            <p class="text-secondary mx-auto mt-2" style="max-width: 650px;">
                Collaborating with world-class manufacturers, renewable innovators, and certified suppliers to deliver top-tier clean energy.
            </p>
        </div>

        <div class="partner-marquee-wrapper" data-aos="fade-up" data-aos-delay="100">
            <div class="partner-marquee-track">
                {{-- Track 1 --}}
                <div class="partner-marquee-group">
                    @foreach ($partnerList as $partner)
                        <div class="partner-marquee-item">
                            @if (!empty($partner->website_url))
                                <a href="{{ $partner->website_url }}" target="_blank" rel="noopener noreferrer" class="partner-marquee-card" title="{{ $partner->name }}">
                            @else
                                <div class="partner-marquee-card" title="{{ $partner->name }}">
                            @endif

                                @if (!empty($partner->image))
                                    <img src="{{ asset('storage/' . $partner->image) }}" alt="{{ $partner->name }}" class="partner-marquee-img" loading="lazy">
                                @else
                                    <div class="partner-marquee-fallback">
                                        <i class="bi {{ $partner->fallback_icon ?? 'bi-building' }} me-2" style="color: {{ $partner->fallback_color ?? '#0284c7' }};"></i>
                                        <span class="partner-marquee-name">{{ $partner->name }}</span>
                                    </div>
                                @endif

                            @if (!empty($partner->website_url))
                                </a>
                            @else
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                {{-- Track 2 (Duplicate for infinite seamless loop) --}}
                <div class="partner-marquee-group" aria-hidden="true">
                    @foreach ($partnerList as $partner)
                        <div class="partner-marquee-item">
                            @if (!empty($partner->website_url))
                                <a href="{{ $partner->website_url }}" target="_blank" rel="noopener noreferrer" class="partner-marquee-card" tabindex="-1">
                            @else
                                <div class="partner-marquee-card">
                            @endif

                                @if (!empty($partner->image))
                                    <img src="{{ asset('storage/' . $partner->image) }}" alt="{{ $partner->name }}" class="partner-marquee-img" loading="lazy">
                                @else
                                    <div class="partner-marquee-fallback">
                                        <i class="bi {{ $partner->fallback_icon ?? 'bi-building' }} me-2" style="color: {{ $partner->fallback_color ?? '#0284c7' }};"></i>
                                        <span class="partner-marquee-name">{{ $partner->name }}</span>
                                    </div>
                                @endif

                            @if (!empty($partner->website_url))
                                </a>
                            @else
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="200">
            <a href="{{ route('partners.index') }}" class="btn btn-outline-primary rounded-pill px-4 btn-sm fw-semibold">
                Explore All Partners <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </section>

    <section class="py-5">
        <div class="container" data-aos="fade-up">
            <div class="card p-4 p-lg-5 text-center">
                <h3>{{ $setting->cta_title ?? 'Ready to switch to solar?' }}</h3>
                <p class="text-secondary">
                    {{ $setting->cta_text ?? 'Talk to our experts and get a customized clean-energy plan.' }}</p>
                <div>
                    <a href="{{ !empty($setting->cta_button_link) ? $setting->cta_button_link : route('contact.index') }}" class="btn btn-primary px-4 py-2">
                        {{ !empty($setting->cta_button_text) ? $setting->cta_button_text : 'Contact Us' }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>
        <script>
            // Ensure page starts at the top on reload
            if ('scrollRestoration' in history) {
                history.scrollRestoration = 'manual';
            }
            window.scrollTo(0, 0);

            // Hero Slider: Swiper continuous track (zero white portion), auto-change, left-click drag & touch swipe
            (function() {
                const initHeroSwiper = function() {
                    const swiperEl = document.querySelector('.hero-swiper');
                    if (!swiperEl) return;

                    const progressFill = document.querySelector('.hero-autoplay-progress-fill');
                    const AUTOPLAY_TIME = 5000;

                    const heroSwiper = new Swiper('.hero-swiper', {
                        loop: true,
                        speed: 850,
                        grabCursor: true,
                        allowTouchMove: true,
                        touchRatio: 1,
                        resistance: true,
                        resistanceRatio: 0.85,
                        preventClicks: true,
                        preventClicksPropagation: true,
                        autoplay: {
                            delay: AUTOPLAY_TIME,
                            disableOnInteraction: false,
                            pauseOnMouseEnter: true,
                        },
                        navigation: {
                            nextEl: '.hero-swiper-next',
                            prevEl: '.hero-swiper-prev',
                        },
                        pagination: {
                            el: '.hero-swiper-pagination',
                            clickable: true,
                        },
                        on: {
                            slideChangeTransitionStart() {
                                const activeSlide = this.slides[this.activeIndex];
                                if (activeSlide) {
                                    const bg = activeSlide.querySelector('.hero-slide-bg');
                                    if (bg) {
                                        bg.style.animation = 'none';
                                        bg.offsetHeight;
                                        bg.style.animation = '';
                                    }
                                }
                            },
                            autoplayTimeLeft(s, time, progress) {
                                if (progressFill) {
                                    progressFill.style.width = Math.min(100, Math.max(0, (1 - progress) * 100)) + '%';
                                }
                            },
                            slideChange() {
                                if (progressFill) {
                                    progressFill.style.width = '0%';
                                }
                            }
                        }
                    });
                };

                if (typeof Swiper !== 'undefined') {
                    initHeroSwiper();
                } else {
                    window.addEventListener('load', initHeroSwiper);
                }
            })();

            // Counter animation
            (function() {
                const counterSection = document.querySelector('.counter-section');

                if (!counterSection) {
                    return;
                }

                const counterElements = counterSection.querySelectorAll('[data-counter-value]');

                const animateCounter = (element) => {
                    if (element.dataset.counted === 'true') {
                        return;
                    }

                    const endValue = parseInt(element.dataset.counterValue || '0', 10);
                    const duration = 1500;
                    const startTime = performance.now();

                    const step = (now) => {
                        const progress = Math.min((now - startTime) / duration, 1);
                        const currentValue = Math.floor(progress * endValue);

                        element.textContent = `${currentValue.toLocaleString()}+`;

                        if (progress < 1) {
                            requestAnimationFrame(step);
                        } else {
                            element.textContent = `${endValue.toLocaleString()}+`;
                            element.dataset.counted = 'true';
                        }
                    };

                    requestAnimationFrame(step);
                };

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            counterElements.forEach(animateCounter);
                            observer.disconnect();
                        }
                    });
                }, {
                    threshold: 0.35,
                });

                observer.observe(counterSection);
            })();
        </script>
    @endpush
@endsection

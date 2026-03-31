@extends('frontend.layouts.app')

@section('title', 'Photo Gallery')

@section('content')
    <section class="py-5">
        <div class="container">
            <h1 class="section-title mb-4">Photo Gallery</h1>
            <div class="row g-4">
                @forelse($items as $item)
                    <div class="col-md-6 col-lg-3" data-aos="zoom-in">
                        <div class="card h-100">
                            @if ($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top"
                                    alt="{{ $item->title }}">
                            @endif
                            <div class="card-body">
                                <h6>{{ $item->title }}</h6>
                            </div>
                        </div>
                </div>@empty<p>No gallery photos yet.</p>
                @endforelse
            </div>
            <div class="mt-4">{{ $items->links() }}</div>
        </div>
    </section>
@endsection

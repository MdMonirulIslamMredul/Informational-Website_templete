@extends('admin.layouts.app')
@section('title', 'Settings')
@section('content')
    <div class="card p-4">
        <h4 class="mb-3">Website Settings</h4>
        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Site Name</label><input class="form-control" name="site_name"
                        value="{{ old('site_name', $setting->site_name) }}" required></div>
                <div class="col-md-6"><label class="form-label">Meta Title</label><input class="form-control"
                        name="meta_title" value="{{ old('meta_title', $setting->meta_title) }}"></div>
                <div class="col-12"><label class="form-label">Meta Description</label>
                    <textarea class="form-control" name="meta_description" rows="2">{{ old('meta_description', $setting->meta_description) }}</textarea>
                </div>
                <div class="col-12"><label class="form-label">SEO Keywords</label><input class="form-control"
                        name="seo_keywords" value="{{ old('seo_keywords', $setting->seo_keywords) }}"></div>
                <div class="col-md-4"><label class="form-label">Facebook URL</label><input class="form-control"
                        name="facebook_url" value="{{ old('facebook_url', $setting->social_links['facebook'] ?? '') }}">
                </div>
                <div class="col-md-4"><label class="form-label">LinkedIn URL</label><input class="form-control"
                        name="linkedin_url" value="{{ old('linkedin_url', $setting->social_links['linkedin'] ?? '') }}">
                </div>
                <div class="col-md-4"><label class="form-label">YouTube URL</label><input class="form-control"
                        name="youtube_url" value="{{ old('youtube_url', $setting->social_links['youtube'] ?? '') }}"></div>
                <div class="col-md-6"><label class="form-label">Logo</label><input type="file" class="form-control"
                        name="logo"></div>
                <div class="col-md-6"><label class="form-label">Favicon</label><input type="file" class="form-control"
                        name="favicon"></div>
            </div>
            <button class="btn btn-primary mt-3">Save Settings</button>
        </form>
    </div>
@endsection

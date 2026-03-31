<div class="row g-3">
    <div class="col-md-6"><label class="form-label">Title</label><input name="title" class="form-control"
            value="{{ old('title', $gallery->title ?? '') }}" required></div>
    <div class="col-md-3"><label class="form-label">Type</label><select name="type" class="form-select">
            <option value="photo" {{ old('type', $gallery->type ?? 'photo') === 'photo' ? 'selected' : '' }}>Photo
            </option>
            <option value="video" {{ old('type', $gallery->type ?? '') === 'video' ? 'selected' : '' }}>Video</option>
        </select></div>
    <div class="col-md-3 form-check mt-4"><input class="form-check-input" type="checkbox" name="status" value="1"
            {{ old('status', $gallery->status ?? true) ? 'checked' : '' }}><label
            class="form-check-label">Active</label></div>
    <div class="col-md-6"><label class="form-label">Photo (if type photo)</label><input type="file" name="image"
            class="form-control"></div>
    <div class="col-md-6"><label class="form-label">YouTube Link (if type video)</label><input name="video_url"
            class="form-control" value="{{ old('video_url', $gallery->video_url ?? '') }}"></div>
    <div class="col-12"><label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description', $gallery->description ?? '') }}</textarea>
    </div>
</div>

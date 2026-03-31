<div class="row g-3">
    <div class="col-md-6"><label class="form-label">Title</label><input name="title" class="form-control"
            value="{{ old('title', $product->title ?? '') }}" required></div>
    <div class="col-md-6"><label class="form-label">Slug</label><input name="slug" class="form-control"
            value="{{ old('slug', $product->slug ?? '') }}"></div>
    <div class="col-md-4"><label class="form-label">Price</label><input name="price" type="number" step="0.01"
            class="form-control" value="{{ old('price', $product->price ?? '') }}"></div>
    <div class="col-md-4"><label class="form-label">Sort Order</label><input name="sort_order" type="number"
            class="form-control" value="{{ old('sort_order', $product->sort_order ?? 0) }}"></div>
    <div class="col-md-2 form-check mt-4"><input class="form-check-input" type="checkbox" name="is_featured"
            value="1" {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}><label
            class="form-check-label">Featured</label></div>
    <div class="col-md-2 form-check mt-4"><input class="form-check-input" type="checkbox" name="status" value="1"
            {{ old('status', $product->status ?? true) ? 'checked' : '' }}><label
            class="form-check-label">Active</label></div>
    <div class="col-12"><label class="form-label">Short Description</label><input name="short_description"
            class="form-control" value="{{ old('short_description', $product->short_description ?? '') }}"></div>
    <div class="col-12"><label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description ?? '') }}</textarea>
    </div>
    <div class="col-12"><label class="form-label">Image</label><input type="file" name="image"
            class="form-control"></div>
</div>

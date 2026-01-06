@extends('layouts.app')

@section('title', 'Create Product')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>Add New Product</h1>
        <a href="{{ route('admin.products.index') }}" class="btn glass">Cancel</a>
    </div>

    <div class="card glass">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="input-group">
                    <label>Product Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Wireless Headphones">
                </div>
                <div class="input-group">
                    <label>Category</label>
                    <select name="category" required>
                        <option value="">Select Category</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Fashion">Fashion</option>
                        <option value="Home">Home</option>
                        <option value="Books">Books</option>
                    </select>
                </div>
                <div class="input-group">
                    <label>Price ($)</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}" required placeholder="0.00">
                </div>
                <div class="input-group">
                    <label>Stock Quantity</label>
                    <input type="number" name="stock" value="{{ old('stock') }}" required placeholder="0">
                </div>
            </div>

            <div class="input-group">
                <label>Description</label>
                <textarea name="description" rows="4" required placeholder="Detailed product description...">{{ old('description') }}</textarea>
            </div>

            <div class="input-group">
                <label>Product Image</label>
                <input type="file" name="image" accept="image/*">
                <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.5rem;">Max size: 2MB. Leave empty to use default image.</p>
            </div>

            <div style="text-align: right; margin-top: 1rem;">
                <button type="submit" class="btn btn-primary" style="padding: 0.75rem 3rem;">Save Product</button>
            </div>
        </form>
    </div>
</div>
@endsection
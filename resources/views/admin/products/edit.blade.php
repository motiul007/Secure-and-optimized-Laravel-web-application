@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
    <div style="max-width: 800px; margin: 0 auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h1>Edit Product: {{ $product->name }}</h1>
            <a href="{{ route('admin.products.index') }}" class="btn glass">Cancel</a>
        </div>

        <div class="card glass">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="input-group">
                        <label>Product Name</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required>
                    </div>
                    <div class="input-group">
                        <label>Category</label>
                        <select name="category" required>
                            <option value="Electronics" {{ $product->category == 'Electronics' ? 'selected' : '' }}>
                                Electronics</option>
                            <option value="Fashion" {{ $product->category == 'Fashion' ? 'selected' : '' }}>Fashion</option>
                            <option value="Home" {{ $product->category == 'Home' ? 'selected' : '' }}>Home</option>
                            <option value="Books" {{ $product->category == 'Books' ? 'selected' : '' }}>Books</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label>Price ($)</label>
                        <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required>
                    </div>
                    <div class="input-group">
                        <label>Stock Quantity</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required>
                    </div>
                </div>

                <div class="input-group">
                    <label>Description</label>
                    <textarea name="description" rows="4"
                        required>{{ old('description', $product->description) }}</textarea>
                </div>

                <div style="display: flex; gap: 2rem; align-items: center; margin-bottom: 1.5rem;">
                    <div
                        style="width: 100px; height: 100px; background: rgba(255,255,255,0.05); border-radius: 8px; overflow: hidden; border: 1px solid var(--glass-border);">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('defaults/product.png') }}"
                            alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="input-group" style="margin-bottom: 0px; flex-grow: 1;">
                        <label>Update Image (Optional)</label>
                        <input type="file" name="image" accept="image/*">
                    </div>
                </div>

                <div style="text-align: right; margin-top: 1rem;">
                    <button type="submit" class="btn btn-primary" style="padding: 0.75rem 3rem;">Update Product</button>
                </div>
            </form>
        </div>
    </div>
@endsection
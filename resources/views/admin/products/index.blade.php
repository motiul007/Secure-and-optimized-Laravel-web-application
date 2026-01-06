@extends('layouts.app')

@section('title', 'Manage Products')

@section('content')
<style>
    .pagination-wrapper svg {
    width: 16px !important;
    height: 16px !important;
}

.pagination-wrapper a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

</style>
    <div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h1>Inventory Management</h1>
            <div style="display: flex; gap: 1rem;">
                <a href="{{ route('admin.dashboard') }}" class="btn glass" style="background: transparent;">Back to
                    Dashboard</a>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add New Product</a>
            </div>
        </div>

        <div class="card glass" style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td style="display: flex; align-items: center; gap: 1rem;">
                                <div
                                    style="width: 40px; height: 40px; background: rgba(255,255,255,0.05); border-radius: 8px; overflow: hidden; border: 1px solid var(--glass-border);">
                                    <img  src="{{ $product->image ? asset($product->image) : asset('defaults/images.jpg') }}"
                                        alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <span style="font-weight: 500;">{{ $product->name }}</span>
                            </td>
                            <td><span
                                    style="background: rgba(99, 102, 241, 0.1); color: var(--primary); padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.875rem;">{{ $product->category }}</span>
                            </td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>
                                @if($product->stock <= 10)
                                    <span style="color: var(--danger); font-weight: 600;">{{ $product->stock }} (Low)</span>
                                @else
                                    {{ $product->stock }}
                                @endif
                            </td>
                            <td style="text-align: right; display: flex; justify-content: flex-end; gap: 0.5rem;">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn glass"
                                    style="padding: 0.4rem 0.8rem; font-size: 0.8rem;">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn glass"
                                        style="padding: 0.4rem 0.8rem; font-size: 0.8rem; color: var(--danger); cursor: pointer;"
                                        onclick="return confirm('Delete this product permanently?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination-wrapper">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
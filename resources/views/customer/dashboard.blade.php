@extends('layouts.app')

@section('title', 'Customer Dashboard')

@section('content')
    <div style="max-width: 800px; margin: 0 auto;">
        <div class="card glass" style="text-align: center; padding: 4rem 2rem;">
            <div
                style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary), var(--accent)); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                <svg style="width: 40px; height: 40px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h1>Welcome, {{ Auth::guard('customer')->user()->name }}!</h1>
            <p style="font-size: 1.125rem; color: var(--text-muted);">You are currently logged in as a customer.</p>

            <div
                style="margin: 2rem 0; padding: 1rem; border-radius: 0.5rem; background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.2); display: inline-flex; align-items: center; gap: 0.5rem;">
                <span class="status-indicator status-online"></span>
                <span style="color: var(--success); font-weight: 500;">Online Session Active</span>
            </div>

            <p style="color: var(--text-muted);">Your presence is being broadcasted to administrators in real-time.</p>

            <div style="margin-top: 3rem; display: flex; justify-content: center; gap: 1rem;">
                <a href="#" class="btn btn-primary">Browse Products</a>
                <form action="{{ route('customer.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn glass">Logout</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Simply join to be counted in the presence channel
        window.Echo.join('online')
            .here((users) => {
                console.log('Online users count:', users.length);
            })
            .error((error) => {
                console.error('Presence Channel Error:', error);
            });
    </script>
@endsection
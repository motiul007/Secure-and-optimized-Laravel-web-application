@extends('layouts.app')

@section('title', 'Customer Login')

@section('content')
    <div style="display: flex; justify-content: center; align-items: center; min-height: 80vh;">
        <div class="card glass" style="width: 100%; max-width: 400px;">
            <h1 style="text-align: center;">Welcome Back</h1>
            <p style="text-align: center; color: var(--text-muted); margin-bottom: 2rem;">Sign in to your customer account
            </p>
            <form method="POST" action="{{ route('customer.login') }}">
                @csrf
                <div class="input-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        placeholder="your@email.com">
                </div>
                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="••••••••">
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Login</button>
            </form>
            <p style="text-align: center; margin-top: 1.5rem; color: var(--text-muted); font-size: 0.875rem;">
                Don't have an account? <a href="{{ route('customer.register') }}"
                    style="color: var(--primary); text-decoration: none;">Register here</a>
            </p>
        </div>
    </div>
@endsection
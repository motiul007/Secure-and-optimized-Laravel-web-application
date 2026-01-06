@extends('layouts.app')

@section('title', 'Customer Register')

@section('content')
    <div style="display: flex; justify-content: center; align-items: center; min-height: 80vh;">
        <div class="card glass" style="width: 100%; max-width: 450px;">
            <h1 style="text-align: center;">Create Account</h1>
            <p style="text-align: center; color: var(--text-muted); margin-bottom: 2rem;">Join our community today</p>
            <form method="POST" action="{{ route('customer.register') }}">
                @csrf
                <div class="input-group">
                    <label>Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="John Doe">
                </div>
                <div class="input-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="john@example.com">
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="input-group">
                        <label>Password</label>
                        <input type="password" name="password" required placeholder="••••••••">
                    </div>
                    <div class="input-group">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" required placeholder="••••••••">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"
                    style="width: 100%; justify-content: center;">Register</button>
            </form>
            <p style="text-align: center; margin-top: 1.5rem; color: var(--text-muted); font-size: 0.875rem;">
                Already have an account? <a href="{{ route('customer.login') }}"
                    style="color: var(--primary); text-decoration: none;">Sign in</a>
            </p>
        </div>
    </div>
@endsection
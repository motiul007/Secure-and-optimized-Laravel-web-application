@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
    <div style="display: flex; justify-content: center; align-items: center; min-height: 80vh;">
        <div class="card glass" style="width: 100%; max-width: 400px;">
            <h1 style="text-align: center;">Admin Login</h1>
            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="input-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        placeholder="admin@example.com">
                </div>
                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="••••••••">
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Sign In</button>
            </form>
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('title', 'Login Page')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/frontend.css') }}">
@endpush

@section('content')

<section class="login-alda-section">
    <div class="login-alda-container">
        <div class="login-alda-card">

            <!-- LEFT -->
            <div class="login-alda-left">
                <img src="{{ asset('assets/img/alda/mascot.png') }}" alt="Logo ALDA" class="login-logo">
            </div>

            <!-- RIGHT -->
            <div class="login-alda-right">

                <h2 class="login-title">Login</h2>
                <p class="login-subtitle">Login to your account continue</p>

                {{-- Breeze Login Form --}}
                <form method="POST" action="{{ route('home') }}" class="account__form">
                    @csrf

                    <!-- Email -->
                    <div class="form-grp">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                            placeholder="Masukkan Email..." required autofocus>
                        @error('email')
                        <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-grp">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" placeholder="Masukkan Password..."
                            required>
                        @error('password')
                        <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Remember + Forgot -->
                    <div class="account__check">
                        <div class="account__check-remember">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Ingat saya</label>
                        </div>

                        @if (Route::has('password.request'))
                        <div class="account__check-forgot">
                            <a href="{{ route('password.request') }}">
                                Lupa Password?
                            </a>
                        </div>
                        @endif
                    </div>

                    <button type="button" class="login-btn">Masuk</button>


                    <div class="account__switch">
                        <p>Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a></p>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
@endsection
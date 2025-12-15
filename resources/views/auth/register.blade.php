@extends('layouts.app')

@section('title', 'Register Page')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/frontend.css') }}">
@endpush


@section('content')

<section class="register-alda-section">
    <div class="register-alda-container">
        <div class="register-alda-card">

            <!-- LEFT -->
            <div class="register-alda-left">
                <img src="{{ asset('assets/img/alda/mascot.png') }}" alt="Logo ALDA" class="register-logo">
            </div>

            <!-- RIGHT -->
            <div class="register-alda-right">

                <h2 class="register-title">Registrasi</h2>
                <p class="register-subtitle">Create your account</p>

                {{-- Breeze Register Form --}}
                <form method="POST" action="{{ route('register') }}" class="register__form">
                    @csrf

                    <!-- Name -->
                    <div class="register-form-grp">
                        <label for="name">Nama</label>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Masukkan Nama..."
                            required
                        >
                        @error('name')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="register-form-grp">
                        <label for="phone">No. Handphone</label>
                        <input
                            id="phone"
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="Masukkan No. Handphone..."
                        >
                        @error('phone')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="register-form-grp">
                        <label for="address">Alamat</label>
                        <input
                            id="address"
                            type="text"
                            name="address"
                            value="{{ old('address') }}"
                            placeholder="Masukkan Alamat..."
                        >
                        @error('address')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="register-form-grp">
                        <label for="email">Email</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Masukkan Email..."
                            required
                        >
                        @error('email')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="register-form-grp">
                        <label for="password">Password</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Masukkan Password..."
                            required
                        >
                        @error('password')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="register-form-grp">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            placeholder="Ulangi Password..."
                            required
                        >
                    </div>

                    <button type="submit" class="register-btn">Daftar</button>
                </form>

            </div>
        </div>
    </div>
</section>

@endsection

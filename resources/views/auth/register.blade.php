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

<div class="register-form-grp">
    <label for="email">Email</label>

    <div style="position:relative;">
        <input
            id="email"
            type="email"
            name="email"
            value="{{ old('email') }}"
            placeholder="Masukkan Email..."
            required
            style="
                width:100%;
                height:40px;
                padding-right:95px;
                font-size:14px;
            "
        >

        <button
    type="button"
    onclick="sendOtp()"
    onmouseover="this.style.background='#f0f0f0'; this.style.borderColor='#888';"
    onmouseout="this.style.background='#fff'; this.style.borderColor='#ccc';"
    style="
        position:absolute;
        right:8px;
        top:50%;
        transform:translateY(-50%);
        font-size:10px;
        padding:4px 8px;
        border-radius:6px;
        border:1px solid #ccc;
        background:#fff;
        cursor:pointer;
        transition: all 0.2s;
    "
>
    OTP
</button>
    </div>
</div>

<div class="register-form-grp" style="margin-top:4px;">
    <label for="otp">OTP</label>
    <input
        type="text"
        name="otp"
        id="otp"
        maxlength="6"
        placeholder="Masukkan kode OTP"
        required
        style="
            width:100%;
            height:40px;
            text-align:center;
            font-size:14px;
            border-radius:6px;
            border:1px solid #ddd;
            color:#000;
            background-color:#fff;
            caret-color:#000;
        "
    >
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


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function sendOtp() {
    const email = document.getElementById('email').value;
    if (!email) {
        Swal.fire({
            icon: 'warning',
            title: 'Email kosong',
            text: 'Isi email dulu sebelum mengirim OTP!',
        });
        return;
    }

    fetch("{{ route('otp.send') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ email })
    })
    .then(res => res.json())
    .then(data => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: data.message,
            timer: 2000,
            showConfirmButton: false
        });
    })
    .catch(err => {
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Terjadi kesalahan saat mengirim OTP.'
        });
    });
}
</script>




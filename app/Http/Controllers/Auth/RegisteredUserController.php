<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmailOtp;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => ['required','confirmed'],
        'otp' => 'required|digits:6'
    ]);

    // cek OTP di cache
    $cachedOtp = Cache::get('otp_'.$request->email);
    if (!$cachedOtp || $cachedOtp != $request->otp) {
        return back()->withErrors(['otp'=>'OTP salah atau kadaluarsa']);
    }

    // hapus OTP setelah valid
    Cache::forget('otp_'.$request->email);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'no_hp' => $request->phone,
        'alamat' => $request->address,
        'role' => 'Customer',
        'email_verified_at' => now(),
    ]);

    Auth::login($user);
    return redirect()->route('welcome-page');
}
}

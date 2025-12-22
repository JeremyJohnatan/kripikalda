<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $otp = rand(100000, 999999);

        // Simpan OTP di cache 5 menit
        Cache::put('otp_'.$request->email, $otp, now()->addMinutes(5));

        Mail::raw("Kode OTP kamu: $otp", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Kode OTP Registrasi');
        });

        return response()->json([
            'message' => 'OTP berhasil dikirim'
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6'
        ]);

        $cachedOtp = Cache::get('otp_'.$request->email);

        if ($cachedOtp && $cachedOtp == $request->otp) {
            // OTP valid, hapus dari cache
            Cache::forget('otp_'.$request->email);
            return response()->json(['message' => 'OTP berhasil diverifikasi', 'verified' => true]);
        }

        return response()->json(['message' => 'OTP salah atau kadaluarsa', 'verified' => false], 422);
    }
}

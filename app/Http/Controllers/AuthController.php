<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\OtpVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $existingUser = User::where('google_id', $googleUser->getId())->first();
            
            if ($existingUser) {
                Auth::login($existingUser);
                return redirect('/dashboard');
            }

            $newUser = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'google_token' => $googleUser->token,
                'profile_image' => $googleUser->getAvatar(),
                'password' => Hash::make(uniqid()),
                'email_verified_at' => now(),
            ]);

            Auth::login($newUser);
            return redirect('/dashboard');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Google login failed');
        }
    }

    public function sendEmailOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();
        
        if (!$user) return response()->json(['error' => 'User not found'], 404);

        $otp = rand(100000, 999999);
        OtpVerification::create([
            'user_id' => $user->id,
            'phone' => $user->email,
            'otp' => $otp,
            'type' => 'email',
            'expires_at' => now()->addMinutes(10),
        ]);

        try {
            Mail::raw("Your OTP is: $otp", function($message) use ($user) {
                $message->to($user->email)->subject('Email Verification OTP');
            });
            return response()->json(['message' => 'OTP sent to email']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send email'], 500);
        }
    }

    public function sendWhatsappOtp(Request $request)
    {
        $request->validate(['phone' => 'required']);
        $user = Auth::user();
        $otp = rand(100000, 999999);

        OtpVerification::create([
            'user_id' => $user->id,
            'phone' => $request->phone,
            'otp' => $otp,
            'type' => 'whatsapp',
            'expires_at' => now()->addMinutes(10),
        ]);

        try {
            $twilio = new \Twilio\Rest\Client(env('TWILIO_AUTH_SID'), env('TWILIO_AUTH_TOKEN'));
            $twilio->messages->create(
                $request->phone,
                ['from' => 'whatsapp:' . env('TWILIO_PHONE'), 'body' => "Your OTP is: $otp"]
            );
            return response()->json(['message' => 'OTP sent via WhatsApp']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send OTP'], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required', 'type' => 'required|in:email,whatsapp']);
        
        $verification = OtpVerification::where([
            'user_id' => Auth::id(),
            'otp' => $request->otp,
            'type' => $request->type,
        ])->where('expires_at', '>', now())->first();

        if (!$verification) return response()->json(['error' => 'Invalid OTP'], 400);

        $verification->update(['verified' => true]);
        Auth::user()->update(['phone_verified' => true]);
        return response()->json(['message' => 'Phone verified']);
    }
}
<?php

namespace App\Http\Controllers;

use App\Jobs\VerifyEmailJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $this->sendCode($user->id);

        return response()->json(['message' => 'Registration successful. Please verify your email.', 'user_id' => $user->id], 200);
    }

    public function sendCode($user_id)
    {
        $user = User::find($user_id);
        $code = rand(100000, 999999);
        VerifyEmailJob::dispatch(['email' => $user->email, 'code' => $code]);
        $user->update(['code' => $code]);
    }

    public function resendEmail(Request $request)
    {
        $request->validate(['user_id' => 'required|numeric']);
        $this->sendCode($request->user_id);
        return response()->json(['message' => 'Verification code resent.'], 200);
    }

    public function verifyEmail(Request $request)
    {
        $request->validate(['code' => 'required|digits:6|numeric', 'user_id' => 'required|numeric']);
        $user = User::find($request->user_id);
        if ($user && $user->code == $request->code) {
            $user->update(['email_verified_at' => now(), 'code' => null]);
            $token = $user->createToken('user_token')->plainTextToken;
            return response()->json(['message' => 'Email verified.', 'user' => $user, 'token' => $token], 200);
        }
        return response()->json(['message' => 'Invalid verification code.'], 422);
    }

    public function login(Request $request)
    {
        $request->validate(['email' => 'required|email', 'password' => 'required']);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            if (!$user->hasVerifiedEmail()) {
                $this->sendCode($user->id);
                Auth::logout();
                return response()->json(['message' => 'Verify your email.', 'code' => 'EMAIL_NOT_VERIFIED'], 422);
            }
            $token = $user->createToken('user_token')->plainTextToken;
            return response()->json(['message' => 'Logged in.', 'user' => $user, 'token' => $token], 200);
        }
        return response()->json(['message' => 'Invalid credentials.'], 422);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ], 200);
    }


    public function redirectToGoogle()
    {
        return Socialite::driver('google')->with(['access_type' => 'offline', 'prompt' => 'consent'])->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = User::firstOrCreate(['email' => $googleUser->email], ['name' => $googleUser->name, 'password' => bcrypt(12345678), 'google_id' => $googleUser->id]);
        Auth::login($user, true);
        return redirect('/');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $this->sendCode($user->id);
            return response()->json(['message' => 'OTP sent.', 'user_id' => $user->id], 200);
        }
        return response()->json(['message' => 'Email not found.'], 422);
    }

    public function verifyForgotEmail(Request $request)
    {
        $request->validate(['code' => 'required|digits:6|numeric', 'user_id' => 'required|numeric']);
        $user = User::find($request->user_id);
        if ($user && $user->code == $request->code) {
            $user->update(['email_verified_at' => now(), 'code' => null]);
            return response()->json(['message' => 'Email verified. Set new password.', 'user_id' => $user->id], 200);
        }
        return response()->json(['message' => 'Invalid verification code.'], 422);
    }
}

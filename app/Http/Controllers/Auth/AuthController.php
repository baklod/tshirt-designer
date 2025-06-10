<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('loginpage');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            
            // Get email domain
            $emailDomain = substr(strrchr($request->email, "@"), 1);
            
            // Redirect based on email domain
            if ($emailDomain === 'admin.com') {
                return redirect()->route('admin.dashboard')->with('success', 'Login successful!');
            } elseif ($emailDomain === 'staff.com') {
                return redirect()->route('staff.dashboard')->with('success', 'Login successful!');
            } else {
                return redirect()->route('customer.dashboard')->with('success', 'Login successful!');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Get email domain
        $emailDomain = substr(strrchr($request->email, "@"), 1);
        
        // Set user role based on email domain
        $role = 'customer';
        if ($emailDomain === 'admin.com') {
            $role = 'admin';
        } elseif ($emailDomain === 'staff.com') {
            $role = 'staff';
        }

        // Create user with role
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role
        ]);

        return redirect()->route('login')
            ->with('success', 'Registration successful! Please login.');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user already exists
            $user = User::where('google_id', $googleUser->id)->first();
            
            if (!$user) {
                // Create a new user if not exists
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => Hash::make(Str::random(16)), // Random password for Google login
                    'role' => 'customer' // Default role for Google users
                ]);
            }

            Auth::login($user, true);
            return redirect()->route('customer.dashboard')->with('success', 'Login successful!');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Google authentication failed. Please try again.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')
            ->with('success', 'You have been logged out successfully');
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $status = Password::sendResetLink($request->only('email'));

        return back()->with('status', 'Password reset link has been sent to your email!');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Handle user authentication request.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        // Check if user is logging in with email or username
        $fieldType = filter_var($credentials['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        if (Auth::attempt([$fieldType => $credentials['email'], 'password' => $credentials['password']], $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))->with('success', 'Selamat datang kembali, '.Auth::user()->name.'!');
        }

        throw ValidationException::withMessages([
            'email' => __('Email atau kata sandi yang Anda masukkan salah.'),
        ]);
    }

    /**
     * Handle user registration request.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'Akun berhasil didaftarkan! Selamat datang di FinTrack.');
    }

    /**
     * Handle quick Google / Demo login for fast access.
     */
    public function googleLogin(Request $request): RedirectResponse
    {
        $demoUser = User::firstOrCreate(
            ['email' => 'demo@fintrack.test'],
            [
                'name' => 'Demo User',
                'password' => Hash::make('password'),
            ]
        );

        Auth::login($demoUser);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'Berhasil masuk dengan akun Google Demo!');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')->with('success', 'Anda telah berhasil keluar.');
    }
}

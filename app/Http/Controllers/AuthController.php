<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Akun;
use App\Models\LevelAkun;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        return view('login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Redirect berdasarkan role
            if ($user->isAdmin()) {
                return redirect()->intended('/homeseller')
                    ->with('success', 'Welcome Admin, ' . $user->name . '!');
            } elseif ($user->isCustomer()) {
                return redirect()->intended('/homepage')
                    ->with('success', 'Welcome, ' . $user->name . '!');
            } else {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Invalid user role.',
                ]);
            }
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials do not match our records.'],
        ]);
    }

    // Tampilkan halaman register
    public function showsignup()
    {
        return view('signup');
    }

    // Generate unique ID untuk akun
    private function generateUniqueId()
    {
        $maxAttempts = 10;
        $attempts = 0;
        
        do {
            $attempts++;
            
            // Use timestamp + random for better uniqueness
            $timestamp = substr(time(), -2); // Last 2 digits of timestamp
            $random = str_pad(rand(10, 99), 2, '0', STR_PAD_LEFT);
            $id = 'U' . $timestamp . $random;
            
            // If we've tried too many times, use a UUID approach
            if ($attempts >= $maxAttempts) {
                $id = 'U' . substr(str_replace('-', '', Str::uuid()), 0, 8);
            }
            
        } while (Akun::where('id_akun', $id)->exists() && $attempts < $maxAttempts + 5);
        
        return $id;
    }

    // Proses register
    public function signup(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|min:10|max:15|unique:akun',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:akun',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            // Generate unique ID
            $uniqueId = $this->generateUniqueId();
            
            // Create user account
            $akun = Akun::create([
                'id_akun' => $uniqueId,
                'id_level' => 2, // Default customer
                'phone' => $request->phone,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Verify the account was created
            if (!$akun || !$akun->id_akun) {
                throw new \Exception('Failed to create account');
            }

            // Login the user
            Auth::login($akun);

            return redirect('/homepage')
                ->with('success', 'Registration successful! Welcome, ' . $akun->name . '!');
                
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database specific errors
            if ($e->getCode() == 23000) { // Integrity constraint violation
                return back()->withErrors([
                    'registration' => 'Registration failed due to duplicate data. Please try again.'
                ])->withInput($request->except('password', 'password_confirmation'));
            }
            
            \Log::error('Database error during registration: ' . $e->getMessage());
            return back()->withErrors([
                'registration' => 'Database error occurred. Please try again.'
            ])->withInput($request->except('password', 'password_confirmation'));
            
        } catch (\Exception $e) {
            // Log the actual error for debugging
            \Log::error('Registration error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()->withErrors([
                'registration' => 'Registration failed: ' . $e->getMessage()
            ])->withInput($request->except('password', 'password_confirmation'));
        }
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'You have been logged out successfully.');
    }

    // Password reset request (opsional)
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }
}
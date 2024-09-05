<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index() 
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && $user->login_attempts >= 3) {
            $timeDiff = now()->diffInMinutes($user->last_login_attempt);
            if ($timeDiff < 5) {
                return response()->json(['error' => 'Too many attempts. Please try again later.'], 429);
            } else {
                $user->login_attempts = 0;
                $user->save();
            }
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user->login_attempts = 0;
            $user->last_login_attempt = null;
            $user->save();

            return redirect('dashboard');
        } else {
            $user->login_attempts++;
            $user->last_login_attempt = now();
            $user->save();
            return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
        }
    }
    public function register_view() 
    {
        return view('auth.register');
    }
      public function register(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:5|confirmed',
            ]);
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            
            Auth::login($user);

            return redirect()->route('dashboard')->with('status', 'Registration successful! You are now logged in.');
            //return redirect('register')->withError('Error');
            
        }
        public function deshboard()
        {
            return view('deshboard');
        }
    
        public function logout()
        {
            Auth::logout();
            return redirect('/');
        }
    }


<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class AuthController extends Controller
{

    public function login()
    {

        $data = [];

        return Inertia::render('Auth/Login')->with($data);
    }
    public function register()
    {
        return Inertia::render('Auth/Register');
    }
    public function do_login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed
            $user = Auth::user();

            //Jika User adalah admin
            if (auth()->user()->role == 'admin') {
                return redirect()->route('admin.dashboard');
            }
            if (auth()->user()->role == 'user') {

                return redirect()->route('app.dashboard');
            }

            return redirect('/')->with(['erorrs' => 'No role.']);
        }

        // Authentication failed
        throw ValidationException::withMessages([
            'email' => ['The provided credentials do not match our records.'],
        ]);
    }

    public function do_register(Request $request)
    {

        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ]);

        $data['role'] = 'user';

        // dd($data);

        $user = User::create($data);

        Auth::login($user);
        return redirect()->route('app.dashboard')->with('success', "Welcome");
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('login');
    }
}

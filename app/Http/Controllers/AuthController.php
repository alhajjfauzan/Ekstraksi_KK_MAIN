<?php

namespace App\Http\Controllers;
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            session()->flash('success_title', 'Berhasil!');
            session()->flash('success_message', 'Anda telah berhasil melakukan Login');

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ])->withInput();
    }

    public function register(Request $request)
    {
       
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',
            ],
            'password_confirmation' => 'required|same:password',
        ], [
            'password.min' => 'Password minimal harus 8 karakter',
            'password.regex' => 'Password harus mengandung minimal 1 huruf besar (A-Z)',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'password_confirmation.same' => 'Konfirmasi password tidak cocok dengan password',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), 
        ]);
        Auth::login($user);
        session()->flash('success_title', 'Berhasil!');
        session()->flash('success_message', 'Anda telah berhasil melakukan Register');

        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('message', 'Anda telah berhasil logout');
    }
}
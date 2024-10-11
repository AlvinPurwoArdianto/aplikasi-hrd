<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = 'admin/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->scopes(['email', 'profile'])->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->stateless()->user(); // Pastikan ini tidak merah

        // Cek apakah user sudah ada di database
        $findUser = User::where('email', $user->getEmail())->first();

        if ($findUser) {
            Auth::login($findUser);
        } else {
            // Simpan user baru jika belum ada
            $newUser = User::create([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'google_id' => $user->getId(),
                'password' => encrypt('dummy_password'), // Password dummy (tidak digunakan)
            ]);

            Auth::login($newUser);
        }

        return redirect()->intended('dashboard');
    }
}

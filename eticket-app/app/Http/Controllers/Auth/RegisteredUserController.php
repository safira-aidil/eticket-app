<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            // dd($request);
            //code...
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
                // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'password' => ['required', 'min:3'],
            ]);

    
            // Pastikan kolom 'usertype' sesuai dengan yang kita buat di web.php tadi
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'usertype' => 'user', // Kita gunakan 'usertype' agar sinkron dengan route dashboard
            ]);
    
            event(new Registered($user));
    
            Auth::login($user);
    
            // Regenerasi session agar user tidak ter-logout otomatis di Laravel 11
            $request->session()->regenerate();
    
            // Redirect langsung menggunakan helper route agar lebih aman dan sesuai standar
            return redirect(route('dashboard', absolute: false));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
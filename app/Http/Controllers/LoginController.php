<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|string|min:5|max:20|regex:/^[a-zA-Z0-9_]{4,20}$/',
            'password' => 'required|string|min:5|max:20',
        ]);

        if (! Auth::attempt($credentials)) {
            return back()->withErrors(['credentials' => 'Credenciales incorrectas, intenta de nuevo ¯\_(ツ)_/¯.']);
        }

        // Regenera session id para proteger contra session fixation.
        $request->session()->regenerate();

        // Guarda marca de última actividad para middleware de inactividad.
        $request->session()->put('last_activity', now()->timestamp);

        return redirect()->intended(route('inicio.index'));
    }
    
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

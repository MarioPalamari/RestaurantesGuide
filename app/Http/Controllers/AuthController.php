<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller{
    public function showLoginForm(){
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'password' => 'required',
        ]);
    
        // Usar 'nombre' y 'password' correctamente en el intento de autenticación
        if (Auth::attempt(['nombre' => $request->nombre, 'password' => $request->password, 'rol_id' => 2])) {
            // Si las credenciales son correctas, regenerar la sesión
            $request->session()->regenerate();
            // Redirigir a la página deseada (dashboard en este caso)
            return redirect()->intended('/restaurantes');
        } else {
            $request->session()->regenerate();
            return redirect()->intended('/admin');

        }   
        // Si las credenciales no coinciden, devolver el error
        return back()->withErrors([
            'nombre' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }
    

    public function showRegisterForm(){
        return view('auth.register');
    }

public function register(Request $request)
{
    $request->validate([
        'nombre' => 'required|unique:usuarios,nombre',
        'email' => 'required|email|unique:usuarios,email',
        'password' => 'required|min:6|confirmed', // Cambiado de 'contra' a 'password'
    ]);

    $user = User::create([
        'nombre' => $request->nombre,
        'email' => $request->email,
        'password' => Hash::make($request->password), // Cambiado de 'contra' a 'password'
        'rol_id' => 2, 
    ]);

    Auth::login($user);
    return redirect('/restaurantes');
}
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}

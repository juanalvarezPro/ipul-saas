<?php

namespace App\Http\Controllers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SocialLoginController extends Controller
{
     // Redirigir al usuario a Google
     public function redirectToProvider()
     {
         return Socialite::driver('google')->redirect();
     }
 
     // Manejar la respuesta de Google
     public function socialCallback()
     {
         try {
             $googleUser = Socialite::driver('google')->user();
 
             // Buscar o crear un usuario en la base de datos
             $user = User::firstOrCreate(
                 ['email' => $googleUser->getEmail()],
                 [
                     'name' => $googleUser->getName(),
                     'avatar' => $googleUser->getAvatar(), // Guardar la URL del avatar
                     'password' => Hash::make($googleUser->getId()), // Usar el ID de Google como contraseña
                 ]
             );
 
             // Autenticar al usuario
             Auth::login($user);
 
             return redirect('/admin'); // Redirigir al dashboard o a donde desees
         } catch (\Exception $e) {
             return redirect('/login')->with('error', 'Error al autenticar con Google');
         }
     }
}

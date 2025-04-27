<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;

class AuthController extends Controller
{
    //
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Connecte un utilisateur existant.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();
        $remember = $request->boolean('remember'); // Récupère la valeur du "se souvenir de moi"

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user(); // Récupère l'utilisateur connecté
            if ($user->role === 'administrateur') {
                return redirect('/dashboardAdmin'); // Redirige l'admin
            }else{
                return redirect('/dashboard_user'); // Redirige l'étudiant

            }
            //return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Les informations d\'identification fournies ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
        //
    }

    /**
     * Affiche le formulaire d'enregistrement.
     */
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    /**
     * Enregistre un nouvel utilisateur et le redirige vers la page de connexion.
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Ne pas connecter automatiquement l'utilisateur
        // Auth::login($user);
        // return redirect()->intended('/dashboard');

        // Rediriger vers la page de connexion avec un message de succès facultatif
        return redirect()->route('login')->with('success', 'Votre compte a été créé avec succès !');
    }

    /**
     * Déconnecte l'utilisateur actuel.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Class `AuthController`
 *
 * Gère l'authentification des utilisateurs : connexion et déconnexion.
 */
class AuthController extends Controller
{
    /**
     * Gère la tentative de connexion de l'utilisateur.
     *
     * Étapes :
     * - Valide les données du formulaire via LoginRequest
     * - Recherche l'utilisateur par son identifiant de connexion.
     * - Vérifie si l'utilisateur existe et est actif.
     * - Vérifie la correspondance du mot de passe.
     * - Connecte l'utilisateur et régénère la session pour éviter le vol de session.
     *
     * @param LoginRequest $request La requête de connexion validée.
     * @return RedirectResponse Redirige vers la page d'accueil si succès,
     *                          sinon redirige vers le formulaire de connexion avec des erreurs.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        // Recherche de l'utilisateur par login
        $user = User::where('login', $credentials['login'])->first();

        // Vérifie si l'utilisateur existe
        if (!$user)
            return to_route('auth.login')->withErrors([
                'login' => 'Identifiant incorrect.',
            ])->onlyInput('login');


        // Vérifie si le compte est actif
        if (!$user->active)
            return to_route('auth.login')->withErrors([
                'login' => 'Compte bloqué.',
            ])->onlyInput('login');


        // Vérifie le mot de passe
        if (!Hash::check($credentials['password'], $user->password))
            return to_route('auth.login')->withErrors([
                'password' => 'Mot de passe incorrect.',
            ])->onlyInput('login');


        // Connecte l'utilisateur et régénère la session pour éviter les attaques de fixation de session
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('index'));
    }

    /**
     * Déconnecte l'utilisateur actuellement authentifié.
     *
     * @return RedirectResponse Redirige vers la page d'accueil après la déconnexion.
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();

        // Redirige vers la page d'accueil
        return to_route('index');
    }
}

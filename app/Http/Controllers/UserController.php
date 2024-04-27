<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRegistrationRequest;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Location;
use App\Models\Role;

class UserController extends Controller
{
    // PAGE D'INSCRIPTION
    public function register() {

        //Récupérer toutes les villes
        $locations = Location::all();

        return view('users.registration', compact('locations'));
    }

    // GESTION DES INSCRIPTIONS
    public function handleRegistration(UserRegistrationRequest $request)
    {
        // Création de l'utilisateur
        $user = new User();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->gender = $request->gender;
        $user->birth_date = $request->birthDate;
        $user->location_id = $request->location;
        $user->save();

        // Assigner le rôle par défaut à l'utilisateur
        $defaultRole = Role::where('name', 'user')->first();
                            
        // Attacher le rôle d'un utilisateur
        if ($defaultRole) {
            $user->roles()->attach($defaultRole);
        }

        // Redirection avec un message de succès
        return redirect('login')->with('success', 'Inscription réussie, vous pouvez vous connectez');
    }

    // PADE DE CONNEXION
    public function login() {
        return view('users.login');
    }

    // GESTION DES CONNEXIONS
    public function handleLogin(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
        ],[
            'password.min' => 'Pour des raisons de sécurité, votre mot de passe doit avoir au moins :min caractères.'
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('dashboard');
        }

        return redirect()->back()->with('error', 'L\'email ou le mot de passe est incorrect');
    }

    // PAGE DU TABLEAU DE BORD
    public function dashboard() {
        return view('dashboard');
    }

    // DÉCONNEXION
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('login');
    }

    // PAGE DE L'UTILISATEUR AUTHENTIFIÉ ou MEMBRE
    public function profil() {
        $id = Auth::id();
        $myArticles = DB::select("select * from articles where user_id='$id'");

        return view('users.profil', compact('myArticles'));
    }
}

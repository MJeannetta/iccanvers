<?php

namespace App\Http\Controllers;

use App\Models\Ministry;
use App\Models\User;
// use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MinistryController extends Controller
{
    // RÉCUPÉRATION DE TOUS LES MINISTÈRES VIA LA BASE DES DONNÉES
    public function index()
    {
        $ministries = Ministry::all();

        return view('ministries.index', compact('ministries'));
    }

    // PAGE DE LA CRÉATION D'UN MINISTÈRE
    public function create()
    {
        // Seul admin a le droit d'accéder à cette page
        if (!Auth::user()->roles->contains('name', 'admin')) {
            return redirect()->route('ministries.index')->with('error', 'Vous n\'avez pas les permissions pour exécuter cette action.');
        }

        $ministries = Ministry::all();

        // Récupérer tous les utilisateurs ayant le rôle de leader (Table pivot)
        $leaders = User::whereHas('roles', function ($query) {
            $query->where('name', 'leader');
        })->get();

        return view('ministries.create', compact('ministries', 'leaders'));
    }

    // RÉCUPÉRATION DES DONNÉES VIA LE FORMULAIRE ET CRÉATION D'UN MINISTÈRE
    public function store(Request $request)
    {
        // Seul admin a le droit d'accéder à cette page
        if (!Auth::user()->roles->contains('name', 'admin')) {
            return redirect()->route('ministries.index')->with('error', 'Vous n\'avez pas les permissions pour exécuter cette action.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'leader' => 'required|exists:users,id',
        ]);

        $ministry = new Ministry();
        $ministry->name = $validatedData['name'];
        $ministry->description = $validatedData['description'];
        $ministry->save();

        // On associe le leader au ministère
        $ministry->users()->sync([$validatedData['leader']]);

        return redirect()->route('ministries.index')->with('success', 'Ministère créé avec succès.');
    }

    // PAGE DE MODIFICATION DU MINISTÈRE
    public function edit(Ministry $ministry)
    {
        // Seul admin a le droit d'accéder à cette page
        if (!Auth::user()->roles->contains('name', 'admin')) {
            return redirect()->route('ministries.index')->with('error', 'Vous n\'avez pas les permissions pour exécuter cette action.');
        }

        // Récupérer tous les utilisateurs ayant le rôle de leader
        $leaders = User::whereHas('roles', function ($query) {
            $query->where('name', 'leader');
        })->get();

        return view('ministries.edit', compact('ministry', 'leaders'));
    }

    // MIS À JOUR DU MINISTÈRE
    public function update(Request $request, Ministry $ministry)
    {
        // Seul admin a le droit d'accéder à cette page
        if (!Auth::user()->roles->contains('name', 'admin')) {
            return redirect()->route('ministries.index')->with('error', 'Vous n\'avez pas les permissions pour exécuter cette action.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'leader' => 'required|exists:users,id',
        ]);

        $ministry->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
        ]);

        // On associe le leader au ministère
        $ministry->users()->sync([$validatedData['leader']]);   // sync() est utilisé pour les identifiants.

        return redirect()->route('ministries.index')->with('success', 'Ministère mis à jour avec succès.');
    }

    // SUPPRESSION DU MINISTÈRE
    public function destroy(Ministry $ministry)
    {
        // Seul admin a le droit d'accéder à cette page
        if (!Auth::user()->roles->contains('name', 'admin')) {
            return redirect()->route('ministries.index')->with('error', 'Vous n\'avez pas les permissions pour exécuter cette action.');
        }

        $ministry->delete();

        return redirect()->route('ministries.index')->with('success', 'Ministère supprimé avec succès.');
    }
}

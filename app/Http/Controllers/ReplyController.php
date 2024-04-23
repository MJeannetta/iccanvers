<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reply;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    // STOCKAGE DES RÉPONSE PROVENANT DU FORMULAIRE
    public function store(Comment $comment, Request $request)
    {
        $validated = $request->validate([
            'content' => 'required',
        ]);

        Reply::create([
            'content' => $validated['content'],   // Utilisons des crochets car ($validated) c'est un tableau et pas une fonction
            'user_id' => Auth::id(),
            'comment_id' => $comment->id,
        ]);

        return back()->with('success', 'Réponse ajoutée avec succès.');
    }

    // PAGE DE MODIFICATION DE LA RÉPONSE DU COMMENTAIRE
    public function edit(Reply $reply)
    {
        // C'est surtout pour l'admin qui ne doit pas modifier les commentaires des utilisateurs
        if (Auth::check() && Auth::id() !== $reply->user_id) {
            return redirect()->route('articles.index')->with('error', "Vous n'êtes pas autorisé à modifier ce commentaire.");        
        }

        return view('replies.edit', compact('reply'));
    }

    // MODIFICATION DU CONTENU DE LA RÉPONSE
    public function update(Request $request, Reply $reply) {
        // Seul l'auteur du contenu de la réponse a le droit de le supprimer
        if (Auth::check() && Auth::id() !== $reply->user_id) {
            return redirect()->route('articles.index')->with('error', "Vous n'êtes pas autorisé à modifier ce commentaire.");        
        }

        // Validation des données entrées par l'utilisateur
        $request->validate([
            'content' => 'required',
        ]);

        // Mise à jour du contenu de la réponse
        $reply->content = $request->content;
        $reply->save();

        // Flash message de succès
        session()->flash('success', 'Réponse mise à jour avec succès');

        // Redirection vers la page blog
        return redirect()->route('articles.index');
    }

    // SUPPRESSION DE LA RÉPONSE DU COMMENTAIRE
    public function destroy(Reply $reply)
    {   
        // Seuls l'auteur du commentaire et l'admin peuvent supprimer ce commentaire
        if (!Auth::check() && (Auth::id() === $reply->user_id || Auth::user()->roles->contains('name', 'admin'))) {
            return redirect()->route('articles.index')->with('error', "Vous n'êtes pas autorisé à supprimer ce commentaire.");
        }

        $reply->delete();

        session()->flash('success', 'Réponse supprimée avec succès');

        // Retour vers la même page.
        return back();
    }
}

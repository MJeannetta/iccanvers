<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Comment;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // RÉCUPÉRATION ET CRÉATION D'UN COMMENTAIRE
    public function store(Article $article, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'content' => ['required', 'string'],
        ]);

        Comment::create([
            'content' => $validated['content'],   // Utilisons des crochets car ($validated) c'est un tableau et pas une fonction
            'article_id' => $article->id,
            'user_id' => Auth::id(), 
        ]);

        return back()->with('success', 'Commentaire publié.');
    }

    // PAGE DE MODIFICATION D'UN COMMENTAIRE
    public function edit(Comment $comment)
    {
        // C'est surtout pour l'admin qui ne doit pas modifier les commentaires des utilisateurs
        if (Auth::check() && Auth::id() !== $comment->user_id) {
            return redirect()->route('articles.index')->with('error', "Vous n'êtes pas autorisé à modifier ce commentaire.");        
        }

        $articles = Article::all();

        return view('comments.edit', compact('articles', 'comment'));
    }

    // MODIFICATION D'UN COMMENTAIRE
    public function update(Request $request, Comment $comment)
    {
        // Seul l'auteur du commentaire peut le modifier
        if ((Auth::check() && Auth::id() !== $comment->user_id)) {
            return redirect()->route('articles.index')->with('error', "Vous n'êtes pas autorisé à modifier ce commentaire.");
        }

        // Validation des données entrées par l'utilisateur
        $request->validate([
            'content' => 'required',
        ]);

        $comment->content = $request->content;
        $comment->save();

        session()->flash('success', 'Commentaire modifié avec succès');

        return redirect('articles');
    }

    // SUPPRESSION D'UN COMMENTAIRE
    public function delete(Comment $comment)
    {
        // Seuls l'auteur du commentaire et l'admin peuvent supprimer ce commentaire
        if(!Auth::check() && (Auth::id() === $reply->user_id || Auth::user()->roles->contains('name', 'admin'))) {
            return redirect()->route('articles.index')->with('error', "Vous n'êtes pas autorisé à supprimer ce commentaire.");
        }

        $comment->delete();

        session()->flash('success', 'Commentaire supprimé avec succès');

        return redirect('articles');
    }
}

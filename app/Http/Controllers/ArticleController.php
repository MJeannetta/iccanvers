<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Policies\ArticlePolicy;

class ArticleController extends Controller
{
    // LA PAGE DU BLOG
    public function index() 
    {
        // $articles = article::all();
        $articles = Article::paginate(5);

        return view('articles.index', compact('articles'));
    }
    
    // CRÉATION D'UN ARTICLE
    public function store(ArticleRequest $request, Article $article)
    {
        // Seul admin a le droit de créer l'article
        if (!Auth::user()->roles->contains('name', 'admin')) {
            return redirect()->route('articles.index')->with('error', 'Vous n\'avez pas les permissions pour créer cet article.');
        }

        Article::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        // La session récupère et affiche le message flash dans une boîte d'alerte
        session()->flash('success', 'Article ajouté avec succès');

        return redirect()->route('articles.index');
    }

    // VUE D'UN ARTICLE EN PARTICULIER
    public function show(Article $article) 
    {
        return view('articles.show', compact('article'));
    }

    // PAGE DE MODIFICATION D'UN article
    public function edit(Article $article) 
    {
        // Seul admin a le droit de voir cette page
        if (!Auth::user()->roles->contains('name', 'admin')) {
            return redirect()->route('articles.index')->with('error', 'Vous n\'avez pas les permissions pour créer cet article.');
        }

        return view('articles.edit', compact('article'));
    }

    // MODIFICATION D'UN ARTICLES
    public function update(Article $article, ArticleRequest $request) 
    {
        // Seul admin a droit de modifier l'article
        if (!Auth::user()->roles->contains('name', 'admin')) {
            return redirect()->route('articles.index')->with('error', 'Vous n\'avez pas les permissions pour modifier cet article.');
        }

        $article->titre = $request->titre;
        $article->description = $request->description;

        $article->save();

        session()->flash('success', 'L\'article a été mis à jour');

        //Redirige vers la route nommée "articles"
        return redirect()->route('articles.index');
    }

    // SUPPRESSION D'UN ARTICLE
    public function delete(Article $article) 
    {
        // Seul admin a droit de supprimer l'article
        if (!Auth::user()->roles->contains('name', 'admin')) {
            return redirect()->route('articles.index')->with('error', 'Vous n\'avez pas les permissions pour supprimer cet article.');
        }

        $article->delete();

        session()->flash('success', 'L\'article a bel et bien été supprimé');

        //Redirige vers la route nommée "articles.index"
        return redirect()->route('articles.index');
    }
}

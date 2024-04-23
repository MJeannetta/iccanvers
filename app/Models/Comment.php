<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // protected $guarded = [];
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = ['content', 'article_id', 'user_id'];

    // RÉCUPÉRER L'AUTEUR DU COMMENTAIRE
    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    // RÉCUPÉRER L'ARTICLE APPARTENANT AU COMMENTAIRE
    public function article() 
    {
        return $this->belongsTo(Article::class);
    }

    // RÉCUPÉRER LES RÉPONSES D'UN COMMENTAIRE
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}

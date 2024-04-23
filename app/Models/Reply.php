<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'user_id', 'comment_id'];

    // RÉCUPÉRER L'AUTEUR OU L'UTILISATEUR ASSOCIÉ À CETTE RÉPONSE
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // RÉCUPÉRER LE COMMENTAIRE ASSOCIÉ À CETTE RÉPONSE
    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }
}

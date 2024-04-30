<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titre',
        'description',
        'user_id',
    ];

    // RÉCUPÉRER LES COMMENTAIRES D'UN ARTICLE
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest(); // "latest()" = Du plus récent au plus ancien commentaire
    }

    // L'ARTICLE D'UN UTILISATEUR
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

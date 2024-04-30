<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        'gender',
        'birth_date',
        'location_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public $timestamps = false;     // Cette ligne pour désactive les timestamps

    // LES ARTICLES D'UN UTILISATEUR
    public function articles() 
    {
        return $this->hasMany(Article::class)->latest();
    }

    // LES COMMENTAIRES D'UN UTILISATEUR
    public function comments() 
    {
        return $this->hasMany(Comment::class)->latest();
    }

    // LES RÉPONSES D'UN UTILISATEUR
    public function replies() 
    {
        return $this->hasMany(Reply::class)->latest();
    }

    // LA VILLE D'UN UTILISATEUR
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    // MINISTÈRES DES MEMBRES
    public function ministries()
    {
        return $this->belongsToMany(Ministry::class);
    }

    // RÔLES DES UTILISATEURS
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    // LE NOM COMPLET D'UN UTILISATEUR
    public function fullname()
    {
        return $this->firstname . ' ' . $this->lastname;
    }
}
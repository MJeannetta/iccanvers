<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public $timestamps = false;     // Cette ligne pour désactive les timestamps

    // LES ÉVÉNEMENTS D'UNE VILLE
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    // LES UTILISATEURS D'UNE VILLE
    public function users()
    {
        return $this->hasMany(User::class);
    }
}

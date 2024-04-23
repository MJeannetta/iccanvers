<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'theme_id',
        'title',
        'description',
        'location_id',
        'start_date',
        'end_date',
        'type',
    ];

    // RÉCUPÉRER LE OU LES ORGANISATEURS DE L'ÉVÉNEMENT
    public function organizers()
    {
        return $this->belongsToMany(Organizer::class);
    }

    // RÉCUPÉRER LE LIEU DE L'ÉVÉNEMENT
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    // RÉCUPÉRER LE THÈME DE L'ÉVÉNEMENT
    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    // protected $dates = ['heure_debut', 'heure_fin']; // Pour qu'elles soient converties en objet carbon
}

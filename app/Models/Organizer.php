<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public $timestamps = false;     // Cette ligne pour désactive les timestamps

    // LES MEMBRES DU MINISTÈRE
    public function events()
    {
        return $this->belongsToMany(Event::class);
    }
}

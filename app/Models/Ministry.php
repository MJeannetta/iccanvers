<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ministry extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public $timestamps = false;     // Cette ligne pour désactive les timestamps

    // LES MEMBRES DU MINISTÈRE
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}

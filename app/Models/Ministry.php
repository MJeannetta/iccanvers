<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ministry extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // LES MEMBRES DU MINISTÈRE
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public $timestamps = false;     // Cette ligne pour désactive les timestamps

    // LES MEMBRES QUI ONT UN OU PLUSIEURS RÔLES
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public $timestamps = false;     // Cette ligne pour désactive les timestamps

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}

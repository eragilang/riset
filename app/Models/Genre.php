<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $table = 'm_genre';

    public function hewans() {
        return $this->hasMany(Hewan::class, 'id_genref', 'id');
    }
}

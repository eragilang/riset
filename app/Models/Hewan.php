<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hewan extends Model
{
    use HasFactory;
    protected $table = 'm_hewan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'id_genre',
        'keterangan',
        'editor',
        'status',
        'vr',
        'objek',
    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class, 'id_genre', 'id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'estado',
        'prioridad',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'tarea_user', 'tarea_id', 'user_id');
    }
}

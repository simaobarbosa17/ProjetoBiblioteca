<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livros extends Model
{
    use HasFactory;

    public function editora()
    {
        return $this->belongsTo(Editoras::class, 'editora_id');
    }

    public function autores()
    {
        return $this->belongsToMany(Autores::class, 'livros_autores');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autores extends Model
{

    use HasFactory;
    public function Livro()
    {
        return $this->belongsToMany(Livros::class, 'livros_autores');
    }
}

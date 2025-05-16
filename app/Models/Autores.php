<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
class Autores extends Model
{

    use HasFactory;
    protected $fillable = ['nome', 'foto'];

    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = Crypt::encryptString($value);
    }
    public function setFotoAttribute($value)
    {
        $this->attributes['foto'] = Crypt::encryptString($value);
    }
    public function getNomeAttribute($value)
    {
        return Crypt::decryptString($value);
    }
    public function getFotoAttribute($value)
    {
        return Crypt::decryptString($value);
    }
    public function Livro()
    {
        return $this->belongsToMany(Livros::class, 'livros_autores');
    }
}

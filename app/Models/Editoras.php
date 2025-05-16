<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
class Editoras extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'logótipo'];

    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = Crypt::encryptString($value);
    }
    public function setLogótipoAttribute($value)
    {
        $this->attributes['logótipo'] = Crypt::encryptString($value);
    }
    public function getNomeAttribute($value)
    {
        return Crypt::decryptString($value);
    }
    public function getLogótipoAttribute($value)
    {
        return Crypt::decryptString($value);
    }
    public function livros()
    {
        return $this->hasMany(Livros::class);
    }
}

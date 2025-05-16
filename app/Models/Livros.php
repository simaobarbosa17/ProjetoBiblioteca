<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Livros extends Model
{
    use HasFactory;
    protected $fillable = ['isbn', 'nome', 'bibliografia', 'preco', 'capa', 'editora_id'];

    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = Crypt::encryptString($value);
    }
    public function setBibliografiaAttribute($value)
    {
        $this->attributes['bibliografia'] = Crypt::encryptString($value);
    }

    public function setIsbnAttribute($value)
    {
        $this->attributes['isbn'] = Crypt::encryptString($value);
    }

    public function setPrecoAttribute($value)
    {
        $this->attributes['preco'] = Crypt::encryptString($value);
    }
    public function setCapaAttribute($value)
    {
        $this->attributes['capa'] = Crypt::encryptString($value);
    }

    public function getNomeAttribute($value)
    {
        return Crypt::decryptString($value);
    }
    public function getBibliografiaAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    public function getIsbnAttribute($value)
    {
        return Crypt::decryptString($value);
    }
    public function getPrecoAttribute($value)
    {
        return Crypt::decryptString($value);
    }
    public function getCapaAttribute($value)
    {
        return Crypt::decryptString($value);
    }


    public function editora()
    {
        return $this->belongsTo(Editoras::class, 'editora_id');
    }

    public function autores()
    {
        return $this->belongsToMany(Autores::class, 'livros_autores');
    }
}
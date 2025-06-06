<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Encomendas extends Model
{
    protected $fillable = [
        'user_id',
        'morada',
        'paga',
    ];

    public function setMoradaAttribute($value)
    {
        $this->attributes['morada'] = crypt::encryptString($value);
    }
    public function getMoradaAttribute($value)
    {
        return Crypt::decryptString($value);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function livros()
    {
        return $this->belongsToMany(Livros::class, 'encomenda_livro', 'encomenda_id', 'livros_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Reviews extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'livros_id',
        'user_id',
        'requesicoes_id',
        'descricao',
    ];
    public function setDescricaoAttribute($value)
    {
        $this->attributes['descricao'] = $value ? Crypt::encryptString($value) : null;
    }
    public function getDescricaoAttribute($value)
    {
        return Crypt::decryptString($value);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function livro()
    {
        return $this->belongsTo(Livros::class, 'livros_id');
    }
    public function requesicao()
    {
        return $this->belongsTo(Requesicoes::class, 'requesicoes_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class requesicoes extends Model
{
    /** @use HasFactory<\Database\Factories\RequesicoesFactory> */
    use HasFactory;
    protected $table = 'requesicoes';

    protected $fillable = [
        'livros_id',
        'user_id',
        'data_requisicao',
        'data_entrega',
    ];

    public function livro()
    {
        return $this->belongsTo(Livros::class, 'livros_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

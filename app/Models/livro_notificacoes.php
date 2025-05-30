<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class livro_notificacoes extends Model
{
    protected $fillable = ['livros_id', 'user_id', 'notificado'];

    public function livro()
    {
        return $this->belongsTo(Livros::class, 'livros_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

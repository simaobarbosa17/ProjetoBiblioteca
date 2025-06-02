<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class carrinho extends Model
{

    protected $table = 'carrinho';

    protected $fillable = [
        'livros_id',
        'user_id',
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

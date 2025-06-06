<?php

namespace App\Models;

use Aoo\Models\Review;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Livros extends Model
{
    use HasFactory;

    protected $fillable = [
        'isbn',
        'nome',
        'editora_id',
        'bibliografia',
        'capa',
        'preco',
        'encomenda_id'
    ];

    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = $value ? Crypt::encryptString($value) : null;
    }

    public function setBibliografiaAttribute($value)
    {
        $this->attributes['bibliografia'] = $value ? Crypt::encryptString($value) : null;
    }

    public function setIsbnAttribute($value)
    {
        $this->attributes['isbn'] = $value ? Crypt::encryptString($value) : null;
    }

    public function setPrecoAttribute($value)
    {
        if ($value === null || $value === '') {
            $this->attributes['preco'] = null;
        } else {
            $this->attributes['preco'] = Crypt::encryptString($value);
        }
    }

    public function setCapaAttribute($value)
    {

        if ($value && Str::startsWith($value, 'http')) {
            $this->attributes['capa'] = $value;
        } else {
            $this->attributes['capa'] = $value ? Crypt::encryptString($value) : null;
        }
    }

    public function getNomeAttribute($value)
    {
        return $value ? $this->tryDecrypt($value) : null;
    }

    public function getBibliografiaAttribute($value)
    {
        return $value ? $this->tryDecrypt($value) : null;
    }

    public function getIsbnAttribute($value)
    {
        return $value ? $this->tryDecrypt($value) : null;
    }

    public function getPrecoAttribute($value)
    {
        return $value ? $this->tryDecrypt($value) : null;
    }

    public function getCapaAttribute($value)
    {

        if ($value && Str::startsWith($value, 'http')) {
            return $value;
        }
        return $value ? $this->tryDecrypt($value) : null;
    }

    /**
     * 
     *
     * @param string $value
     * @return string
     */
    protected function tryDecrypt($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            Log::warning("Erro ao descriptografar: " . $e->getMessage());
            return $value;
        }
    }

    public function editora()
    {
        return $this->belongsTo(Editoras::class, 'editora_id');
    }

    public function autores()
    {
        return $this->belongsToMany(Autores::class, 'livros_autores');
    }

    public function requesicoes()
    {
        return $this->hasMany(\App\Models\requesicoes::class, 'livros_id');
    }
    public function reviews()
    {
        return $this->hasMany(Reviews::class, 'livros_id');
    }
    public function carrinho()
    {
        return $this->hasMany(carrinho::class, 'livros_id');
    }
    public function encomendas()
    {
        return $this->belongsToMany(Encomendas::class, 'encomenda_livro', 'livros_id', 'encomenda_id');
    }

}
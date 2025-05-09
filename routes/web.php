<?php

use App\Http\Controllers\ExportarController;
use App\Models\Autores;
use App\Models\Editoras;
use App\Models\Livros;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\ExportController;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $sort = Request::get('sort', 'isbn');
        $ordenar = Request::get('ordenar', 'asc');
        $procurar = Request::get('procurar');
        $porpag = 10;
        $pagatual = LengthAwarePaginator::resolveCurrentPage();

        $livros = Livros::with('editora', 'autores')->get();



        $livros = $livros->map(function ($livro) {
            $livro->nome = Crypt::decryptString($livro->nome);
            $livro->isbn = Crypt::decryptString($livro->isbn);
            $livro->preco = Crypt::decryptString($livro->preco);
            $livro->bibliografia = Crypt::decryptString($livro->bibliografia);
            $livro->capa = Crypt::decryptString($livro->capa);
            $livro->editora->nome = Crypt::decryptString($livro->editora->nome);
            foreach ($livro->autores as $autor) {
                $autor->nome = Crypt::decryptString($autor->nome);
            }
            return $livro;
        });


        if ($procurar) {
            $livros = $livros->filter(function ($livro) use ($procurar) {
                $search = strtolower($procurar);
                return str_contains(strtolower($livro->nome), $search)
                    || str_contains(strtolower($livro->isbn), $search)
                    || ($livro->editora && str_contains(strtolower($livro->editora->nome), $search))
                    || $livro->autores->contains(function ($autor) use ($search) {
                        return str_contains(strtolower($autor->nome), $search);
                    });
            });
        }

        if ($sort == 'editora') {
            $livros = $livros->sortBy(fn($livro) => $livro->editora ? $livro->editora->nome : '', SORT_NATURAL | SORT_FLAG_CASE);
        } elseif ($sort == 'autor') {
            $livros = $livros->sortBy(function ($livro) {
                return implode(', ', $livro->autores->pluck('nome')->toArray());
            }, SORT_NATURAL | SORT_FLAG_CASE);
        } else {
            $livros = $livros->sortBy(fn($livro) => $livro->$sort, SORT_NATURAL | SORT_FLAG_CASE);
        }

        if ($ordenar === 'desc') {
            $livros = $livros->reverse();
        }

        $paginacao = new LengthAwarePaginator(
            $livros->forPage($pagatual, $porpag)->values(),
            $livros->count(),
            $porpag,
            $pagatual,
            ['path' => Request::url(), 'query' => Request::query()]
        );


        return view('dashboard', ['livro' => $paginacao]);
    })->name('dashboard');
    Route::get('/autores', function () {
        $sort = Request::get('sort', 'id');
        $ordenar = Request::get('ordenar', 'asc');
        $procurar = Request::get('procurar');
        $porpag = 10;
        $pagatual = LengthAwarePaginator::resolveCurrentPage();

        $autores = Autores::get();

        $autores = $autores->map(function ($autor) {
            $autor->nome = Crypt::decryptString($autor->nome);
            $autor->foto = Crypt::decryptString($autor->foto);
            return $autor;
        });

        if ($procurar) {
            $autores = $autores->filter(function ($autor) use ($procurar) {
                $search = strtolower($procurar);
                return str_contains(strtolower($autor->nome), $search) ||
                    str_contains((string) $autor->id, $search);
            });
        }

        $autores = $autores->sortBy(fn($autor) => $autor->$sort, SORT_NATURAL | SORT_FLAG_CASE);

        if ($ordenar === 'desc') {
            $autores = $autores->reverse();
        }

        $paginacao = new LengthAwarePaginator(
            $autores->forPage($pagatual, $porpag)->values(),
            $autores->count(),
            $porpag,
            $pagatual,
            ['path' => Request::url(), 'query' => Request::query()]
        );

        return view('autores', ['autor' => $paginacao]);
    })->name('autores');
    Route::get('/editoras', function () {
        $sort = Request::get('sort', 'id');
        $ordenar = Request::get('ordenar', 'asc');
        $procurar = Request::get('procurar');
        $porpag = 10;
        $pagatual = LengthAwarePaginator::resolveCurrentPage();

        $editoras = Editoras::get();

        $editoras = $editoras->map(function ($editora) {
            $editora->nome = Crypt::decryptString($editora->nome);
            $editora->logótipo = Crypt::decryptString($editora->logótipo);
            return $editora;
        });

        if ($procurar) {
            $editoras = $editoras->filter(function ($editora) use ($procurar) {
                $search = strtolower($procurar);
                return str_contains(strtolower($editora->nome), $search) ||
                    str_contains((string) $editora->id, $search);
            });
        }

        $editoras = $editoras->sortBy(fn($editoras) => $editoras->$sort, SORT_NATURAL | SORT_FLAG_CASE);

        if ($ordenar === 'desc') {
            $editoras = $editoras->reverse();
        }

        $paginacao = new LengthAwarePaginator(
            $editoras->forPage($pagatual, $porpag)->values(),
            $editoras->count(),
            $porpag,
            $pagatual,
            ['path' => Request::url(), 'query' => Request::query()]
        );
        return view('editoras', ['editora' => $paginacao]);
    })->name('editoras');
});

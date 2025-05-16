<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Crypt;
use App\Models\Livros;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'isbn');
        $ordenar = $request->get('ordenar', 'asc');
        $procurar = $request->get('procurar');
        $porpag = 10;
        $pagatual = LengthAwarePaginator::resolveCurrentPage();

        $livros = Livros::with('editora', 'autores')->get();

        if ($procurar) {
            $search = strtolower($procurar);
            $livros = $livros->filter(function ($livro) use ($search) {
                return str_contains(strtolower($livro->nome), $search)
                    || str_contains(strtolower($livro->isbn), $search)
                    || ($livro->editora && str_contains(strtolower($livro->editora->nome), $search))
                    || $livro->autores->contains(fn($autor) => str_contains(strtolower($autor->nome), $search));
            });
        }

        $livros = match ($sort) {
            'editora' => $livros->sortBy(fn($livro) => $livro->editora?->nome ?? '', SORT_NATURAL | SORT_FLAG_CASE),
            'autor' => $livros->sortBy(fn($livro) => implode(', ', $livro->autores->pluck('nome')->toArray()), SORT_NATURAL | SORT_FLAG_CASE),
            default => $livros->sortBy(fn($livro) => $livro->$sort, SORT_NATURAL | SORT_FLAG_CASE),
        };

        if ($ordenar === 'desc') {
            $livros = $livros->reverse();
        }

        $paginacao = new LengthAwarePaginator(
            $livros->forPage($pagatual, $porpag)->values(),
            $livros->count(),
            $porpag,
            $pagatual,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        $view = $request->is('admin/*') ? 'admin.dashboard' : 'dashboard';

        return view($view, ['livro' => $paginacao]);
    }
}

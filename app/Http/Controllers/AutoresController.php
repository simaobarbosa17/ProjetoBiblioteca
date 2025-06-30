<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Crypt;
use App\Models\Autores;


class AutoresController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'id');
        $ordenar = $request->get('ordenar', 'asc');
        $procurar = $request->get('procurar');
        $porpag = 10;
        $pagatual = LengthAwarePaginator::resolveCurrentPage();

        $autores = Autores::get();

        if ($procurar) {
            $search = strtolower($procurar);
            $autores = $autores->filter(fn($autor) => str_contains(strtolower($autor->nome), $search) || str_contains((string) $autor->id, $search));
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
            ['path' => $request->url(), 'query' => $request->query()]
        );
      
        return view('admin.autores', ['autor' => $paginacao]);
    }
}

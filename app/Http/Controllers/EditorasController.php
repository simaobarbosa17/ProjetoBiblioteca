<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Editoras;
class EditorasController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'id');
        $ordenar = $request->get('ordenar', 'asc');
        $procurar = $request->get('procurar');
        $porpag = 10;
        $pagatual = LengthAwarePaginator::resolveCurrentPage();

        $editoras = Editoras::get();

        if ($procurar) {
            $search = strtolower($procurar);
            $editoras = $editoras->filter(fn($editora) => str_contains(strtolower($editora->nome), $search) || str_contains((string) $editora->id, $search));
        }

        $editoras = $editoras->sortBy(fn($editora) => $editora->$sort, SORT_NATURAL | SORT_FLAG_CASE);

        if ($ordenar === 'desc') {
            $editoras = $editoras->reverse();
        }

        $paginacao = new LengthAwarePaginator(
            $editoras->forPage($pagatual, $porpag)->values(),
            $editoras->count(),
            $porpag,
            $pagatual,
            ['path' => $request->url(), 'query' => $request->query()]
        );
    
        return view('admin.editoras', ['editora' => $paginacao]);
    }
}

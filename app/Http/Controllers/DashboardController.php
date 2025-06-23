<?php

namespace App\Http\Controllers;

use App\Models\carrinho;
use App\Models\livro_notificacoes;
use App\Models\requesicoes;
use Illuminate\Http\Request;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
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
    public function show($livro)
    {
        $livro = Livros::with([
            'editora',
            'autores',
            'reviews' => function ($query) {
                $query->where('validado', true)->with('user');
            }
        ])->findOrFail($livro);


        $livro->disponivel = $livro->stock >= 1;


        $user = Auth::user();

        $notificado = false;
        $nocarrinho = false;
        $jaSolicitado = false;

        if ($user) {
            $notificado = livro_notificacoes::where('user_id', $user->id)
                ->where('livros_id', $livro->id)
                ->where('notificado', false)
                ->exists();
            $jaSolicitado = requesicoes::where('user_id', $user->id)
                ->where('livros_id', $livro->id)
                ->whereDate('data_entrega', '>=', now())
                ->exists();
            $nocarrinho = carrinho::where('user_id', $user->id)
                ->where('livros_id', $livro->id)
                ->exists();
        }



        $todosLivros = Livros::all()->except($livro->id);
        $descrBase = $this->limparTexto($livro->bibliografia);

        $relacionados = $todosLivros->map(function ($outro) use ($descrBase) {
            $descrOutro = $this->limparTexto($outro->bibliografia);
            $similaridade = $this->calcularSimilaridade($descrBase, $descrOutro);
            $outro->similaridade = $similaridade;
            return $outro;
        })->sortByDesc('similaridade')->take(3);



        return view('detalhelivro', compact('livro', 'notificado', 'relacionados', 'nocarrinho', 'jaSolicitado'));
    }
    public function notificar($livroId)
    {
        $livro = Livros::findOrFail($livroId);


        $existe = livro_notificacoes::where('livros_id', $livro->id)
            ->where('user_id', auth()->id())
            ->where('notificado', false)
            ->exists();

        if (!$existe) {
            livro_notificacoes::create([
                'livros_id' => $livro->id,
                'user_id' => auth()->id(),
                'notificado' => false,
            ]);
        }

        return back()->with('success', 'Serás notificado quando o livro estiver disponível.');
    }
    private function limparTexto($texto)
    {
        return collect(explode(' ', strtolower(strip_tags($texto))))
            ->reject(fn($word) => in_array($word, ['de', 'a', 'o', 'e', 'em', 'um', 'para', 'com', 'do', 'na', 'no', 'por', 'que', 'as', 'os']))
            ->map(fn($w) => trim(preg_replace('/[^a-z0-9]/', '', $w)))
            ->filter()
            ->values()
            ->toArray();
    }

    private function calcularSimilaridade(array $base, array $comparar)
    {
        $intersecao = array_intersect($base, $comparar);
        $union = array_unique(array_merge($base, $comparar));
        return count($union) > 0 ? count($intersecao) / count($union) : 0;
    }
}

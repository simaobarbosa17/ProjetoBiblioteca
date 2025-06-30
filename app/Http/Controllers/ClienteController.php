<?php

namespace App\Http\Controllers;

use App\Models\requesicoes;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\LembreteEntrega;


class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requisicao = requesicoes::paginate(10);

        $requisicoesAtivas = requesicoes::with(['livro', 'user'])
            ->where('estado', 'ativa')
            ->latest()
            ->paginate(15);

        $requisicoesDevolvidas = requesicoes::with(['livro', 'user'])
            ->where('estado', 'devolvida')
            ->latest()
            ->paginate(15);


        $totalAtivas = requesicoes::where('estado', 'ativa')->count();

        $totalDevolvidas = requesicoes::where('estado', 'devolvida')->count();

        $ultimos30dias = requesicoes::whereDate('data_requisicao', '>=', now()->subDays(30))->count();

        $entreguesHoje = requesicoes::whereDate('data_devolvida', now()->toDateString())->count();
        
        return view('admin.todasrequesicoes', compact(
            'requisicoesAtivas',
            'requisicoesDevolvidas',
            'totalAtivas',
            'totalDevolvidas',
            'ultimos30dias',
            'entreguesHoje',
            'requisicao'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $userId = auth()->id();
        $userId = auth()->id();

        $requisicoes = requesicoes::with('livro')
            ->where('user_id', $userId)
            ->get();

        $ativas = requesicoes::where('user_id', $userId)
            ->where('estado', 'ativa')
            ->with('livro')
            ->get();

        $naoAtivas = requesicoes::where('user_id', $userId)
            ->where('estado', 'devolvida')
            ->with('livro', 'review')
            ->get();

        return view('verequesicao', compact('ativas', 'naoAtivas', 'requisicoes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

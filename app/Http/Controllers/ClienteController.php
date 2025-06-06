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
        $requisicoes = requesicoes::with(['livro', 'user'])->latest()->paginate(15);

        $totalAtivas = requesicoes::whereDate('data_entrega', '>=', now())->count();

        $ultimos30dias = requesicoes::whereDate('data_requisicao', '>=', now()->subDays(30))->count();

        $entreguesHoje = requesicoes::whereDate('data_entrega', now()->toDateString())->count();

        return view('admin.todasrequesicoes', compact('requisicoes', 'totalAtivas', 'ultimos30dias', 'entreguesHoje'));
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
        $requisicoes = auth()->user()->requisicoes()->with('livro', 'review')->latest()->get();

        $hoje = now()->toDateString();

        $ativas = $requisicoes->filter(function ($r) use ($hoje) {
            return Carbon::parse($r->data_entrega)->toDateString() > $hoje;
        });

        $naoAtivas = $requisicoes->filter(function ($r) use ($hoje) {
            return Carbon::parse($r->data_entrega)->toDateString() <= $hoje;
        });
        return view('verequesicao', compact('ativas', 'naoAtivas'));
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

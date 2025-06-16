<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\requesicoes;
use App\Models\Livros;
use App\Mail\RequisicaoRealizada;
use Illuminate\Support\Facades\Mail;

class RequesicoesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    /**
     * Display the specified resource.
     */
    public function show($livroId)
    {
        $livro = Livros::findOrFail($livroId);
        return view('requesicoes', compact('livro'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'livros_id' => 'required|exists:livros,id',
            'data_requisicao' => 'required|date',
            'data_entrega' => 'required|date|after_or_equal:data_requisicao',
        ]);

        $userId = Auth::id();
        $livroId = $request->livros_id;
        $dataInicio = Carbon::parse($request->data_requisicao);
        $dataFim = Carbon::parse($request->data_entrega);
        $livro = Livros::findOrFail($livroId);

        if ($livro->stock <= 0) {
            return back()->with('error', 'Este livro não tem stock disponível para requisição.');
        }

        $livrosAtivos = requesicoes::where('user_id', $userId)
            ->whereDate('data_entrega', '>=', now())
            ->count();

        if ($livrosAtivos >= 3) {
            return back()->with('error', 'Você já requisitou o número máximo de 3 livros.');
        }


        $conflito = requesicoes::where('livros_id', $livroId)
            ->where(function ($query) use ($dataInicio, $dataFim) {
                $query->whereBetween('data_requisicao', [$dataInicio, $dataFim])
                    ->orWhereBetween('data_entrega', [$dataInicio, $dataFim])
                    ->orWhere(function ($query) use ($dataInicio, $dataFim) {
                        $query->where('data_requisicao', '<=', $dataInicio)
                            ->where('data_entrega', '>=', $dataFim);
                    });
            })
            ->exists();

        if ($conflito) {
            return back()->with('error', 'Este livro já está requisitado nesse período.');
        }


        $requisicao = requesicoes::create([
            'user_id' => $userId,
            'livros_id' => $livroId,
            'data_requisicao' => $dataInicio,
            'data_entrega' => $dataFim,
            'estado' => 'ativa',
        ]);

        Mail::to(auth()->user()->email)->send(new RequisicaoRealizada($requisicao));

        $adminEmails = \App\Models\User::where('role', 'admin')->pluck('email');
        foreach ($adminEmails as $email) {
            Mail::to($email)->send(new \App\Mail\RequisicaoAdmin($requisicao));
        }

        return redirect()->route('dashboard')->with('success', 'Livro requisitado com sucesso.');
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
    public function devolver($id)
    {

        $requisicao = requesicoes::findOrFail($id);

        if ($requisicao->estado !== 'ativa') {
            return back()->with('error', 'Esta requisição já foi devolvida.');
        }

        $requisicao->estado = 'devolvida';
        $requisicao->save();

        return back()->with('success', 'Livro devolvido com sucesso.');
    }
}

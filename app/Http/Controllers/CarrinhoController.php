<?php

namespace App\Http\Controllers;

use App\Models\carrinho;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CarrinhoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carrinho = auth()->user()->carrinho()->with('livro', 'user')->get();
        return view('vercarrinho', compact('carrinho'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($request)
    {


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'livros_id' => 'required|exists:livros,id',
        ]);

        $userId = Auth::id();
        $livroId = $request->livros_id;

        $carrinho = carrinho::create([
            'user_id' => $userId,
            'livros_id' => $livroId,
        ]);

        return redirect()->route('dashboard')->with('success', 'Livro adicionado ao carrinho!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $carrinho = carrinho::findOrFail($id);
        $carrinho->delete();
        return redirect()->route('vercarrinho')->with('success', 'Livro removido do carrinho com sucesso.');
    }
}

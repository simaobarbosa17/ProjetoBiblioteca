<?php

namespace App\Http\Controllers;

use App\Models\carrinho;
use App\Models\Encomendas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;


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
    public function atualizar(Request $request, $id)
    {
        $request->validate([
            'quantidade' => 'required|integer|min:1',
        ]);

        $carrinho = Carrinho::findOrFail($id);

        if ($carrinho->user_id !== auth()->id()) {
            abort(403);
        }
        $livro = $carrinho->livro;

        if ($request->quantidade > $livro->stock) {
            return redirect()->back()->with('error', 'Quantidade solicitada excede o estoque disponível.');
        }
        $carrinho->quantidade = $request->quantidade;
        $carrinho->save();

        return redirect()->back()->with('success', 'Quantidade atualizada com sucesso!');
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
    public function mostrarFinalizar()
    {
        $user = auth()->user();
        $carrinho = Carrinho::with('livro')->where('user_id', $user->id)->get();
        $total = $carrinho->sum(fn($item) => $item->livro->preco * $item->quantidade);

        return view('finalizarcompra', compact('carrinho', 'total'));
    }

    public function processarPagamento(Request $request)
    {
        $request->validate([
            'morada' => 'required|string|max:255',
        ]);

        $user = auth()->user();


        $carrinho = Carrinho::with('livro')->where('user_id', $user->id)->get();

        foreach ($carrinho as $item) {
            if ($item->quantidade > $item->livro->stock) {
                return redirect()->back()
                    ->withInput()
                    ->with('erro', "Não há stock suficiente para o livro '{$item->livro->nome}'. Stock disponível: {$item->livro->stock}, quantidade no carrinho: {$item->quantidade}.");
            }
        }


        $encomenda = Encomendas::where('user_id', $user->id)
            ->where('paga', false)
            ->first();

        if (!$encomenda) {
            $encomenda = Encomendas::create([
                'user_id' => $user->id,
                'morada' => $request->morada,
                'paga' => false,
            ]);
        } else {
            $encomenda->morada = $request->morada;
            $encomenda->save();
        }

        $livrosIds = $carrinho->pluck('livro.id')->toArray();
        $encomenda->livros()->sync($livrosIds);

        $total = $carrinho->sum(fn($item) => $item->livro->preco * $item->quantidade);

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => 'Compra de Livros',
                        ],
                        'unit_amount' => intval($total * 100),
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            'metadata' => [
                'encomenda_id' => $encomenda->id,
            ],
            'success_url' => route('pagamento.sucesso', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('dashboard') . '?cancelado=1',
        ]);

        return redirect($session->url);
    }

    public function adminindex()
    {
        
        $encomendas = Encomendas::with('user', 'livros')->paginate(10);
        return view('admin.verencomendas', compact('encomendas'));
    }

}

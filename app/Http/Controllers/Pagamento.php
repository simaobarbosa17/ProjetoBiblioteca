<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class Pagamento extends Controller
{
    public function sucesso(Request $request)
    {
        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            return redirect()->route('dashboard')->with('erro', 'Sessão não encontrada.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));
        $session = StripeSession::retrieve($sessionId);

        $encomendaId = $session->metadata->encomenda_id ?? null;

        if ($session->payment_status === 'paid' && $encomendaId) {
            $encomenda = \App\Models\Encomendas::find($encomendaId);

            if ($encomenda && !$encomenda->paga) {
                $encomenda->paga = true;
                $encomenda->save();

                $carrinho = \App\Models\Carrinho::with('livro')->where('user_id', $encomenda->user_id)->get();

              
                $livrosIds = $carrinho->pluck('livro.id')->toArray();
                $encomenda->livros()->syncWithoutDetaching($livrosIds);

               
                foreach ($carrinho as $item) {
                    $item->delete();
                }
            }

            return view('pagamento-sucesso');
        }

        return redirect()->route('dashboard')->with('erro', 'Pagamento não confirmado.');
    }
}

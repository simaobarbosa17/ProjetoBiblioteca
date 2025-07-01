<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Mail\LivroCompradoMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\LivroCompradoAdminMail;

class Pagamento extends Controller
{
    public function sucesso(Request $request)
    {
        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            return redirect()->route('dashboard')->with('erro', 'Sessão não encontrada.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));
        $session = Session::retrieve($sessionId);

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
                    $livro = $item->livro;
                    if ($livro->stock >= $item->quantidade) {
                        $livro->stock -= $item->quantidade;
                        $livro->save();
                    } else {

                        return redirect()->route('dashboard')->with('erro', "Estoque insuficiente para o livro {$livro->nome}.");
                    }


                    $item->delete();
                }
                Mail::to($encomenda->user->email)->send(new LivroCompradoMail($encomenda));

               
                $admins = User::where('role', 'admin')->pluck('email');
                foreach ($admins as $adminEmail) {
                    Mail::to($adminEmail)->send(new LivroCompradoAdminMail($encomenda));
                }
            }
            app('SiteLogger')('Livro', $encomendaId, 'Livro Comprado ');
            return view('pagamento-sucesso');
        }

        return redirect()->route('dashboard')->with('erro', 'Pagamento não confirmado.');
    }
}

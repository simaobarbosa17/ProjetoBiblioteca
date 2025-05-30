<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reviews;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReviewEstado;

class AdminReviewController extends Controller
{
    // Lista todas as reviews pendentes
    public function index()
    {
        $reviews = Reviews::with(['user', 'livro'])
            ->where('validado', false)
            ->get();

        return view('admin.reviews', compact('reviews'));
    }

    // Aprova uma review
    public function aprovar($id)
    {
        $review = Reviews::findOrFail($id);
        $review->validado = true;
        $review->justificacao = null;
        $review->save();

        // Envia email para o usuário
        Mail::to($review->user->email)->send(new ReviewEstado($review, true));

        return back()->with('success', 'Review aprovada com sucesso!');
    }

    // Recusa uma review
    public function recusar(Request $request, $id)
    {
        $request->validate([
            'justificacao' => 'required|string|min:5',
        ]);

        $review = Reviews::findOrFail($id);
        $review->validado = false;
        $review->justificacao = $request->justificacao;
        $review->save();

        // Envia email para o usuário
        Mail::to($review->user->email)->send(new ReviewEstado($review, false));

        return back()->with('success', 'Review recusada com sucesso!');
    }
}
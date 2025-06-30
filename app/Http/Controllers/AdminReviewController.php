<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reviews;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReviewEstado;

class AdminReviewController extends Controller
{
  
    public function index()
    {
        $reviews = Reviews::with(['user', 'livro'])
            ->where('validado', false)
            ->paginate(10);

        return view('admin.reviews', compact('reviews'));
    }

   
    public function aprovar($id)
    {
        $review = Reviews::findOrFail($id);
        $review->validado = true;
        $review->justificacao = null;
        $review->save();

       
        Mail::to($review->user->email)->send(new ReviewEstado($review, true));

        app('SiteLogger')('Review', $review->id, 'Review Aprovada ');
        return back()->with('success', 'Review aprovada com sucesso!');
    }

   
    public function recusar(Request $request, $id)
    {
        $request->validate([
            'justificacao' => 'required|string|min:5',
        ]);

        $review = Reviews::findOrFail($id);
        $review->validado = false;
        $review->justificacao = $request->justificacao;
        $review->save();

        
        Mail::to($review->user->email)->send(new ReviewEstado($review, false));
        app('SiteLogger')('Review', $review->id, 'Review Recusada ');
        return back()->with('success', 'Review recusada com sucesso!');
    }
}
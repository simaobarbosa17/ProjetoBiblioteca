<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reviews;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ReviewsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'requesicoes_id' => 'required|exists:requesicoes,id',
            'livros_id' => 'required|exists:livros,id',
            'descricao' => 'required|string|min:5',
        ]);

        $review = Reviews::create([
            'user_id' => auth()->id(),
            'requesicoes_id' => $request->requesicoes_id,
            'livros_id' => $request->livros_id,
            'descricao' => $request->descricao,
            'validado' => false,
        ]);

        $adminEmails = \App\Models\User::where('role', 'admin')->pluck('email');
        foreach ($adminEmails as $email) {
            Mail::to($email)->send(new \App\Mail\ReviewAdmin($review));
        }
         app('SiteLogger')('Review', $review->id, 'Review Criada ');
        return redirect()->back()->with('success', 'Review enviada com sucesso!');
    }
}

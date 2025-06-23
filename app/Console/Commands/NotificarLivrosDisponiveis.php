<?php

namespace App\Console\Commands;

use App\Models\livro_notificacoes;
use App\Models\Livros;
use App\Models\requesicoes;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\LivroDisponivel;


class NotificarLivrosDisponiveis extends Command
{
    protected $signature = 'notificar:livros-disponiveis';
    protected $description = 'Notifica os usuários quando os livros são devolvidos hoje';

    public function handle()
    {
        $livrosDisponiveis = Livros::where('stock', '>=', 1)->get();

        foreach ($livrosDisponiveis as $livro) {
            $notificacoesPendentes = livro_notificacoes::where('livros_id', $livro->id)
                ->where('notificado', false)
                ->with('user')
                ->get();

            foreach ($notificacoesPendentes as $notificacao) {
                Mail::to($notificacao->user->email)->send(new LivroDisponivel($livro));

                $notificacao->update(['notificado' => true]);

                $this->info("Notificação enviada para {$notificacao->user->email} sobre o livro '{$livro->nome}'");
            }
        }

        return Command::SUCCESS;
    }
}

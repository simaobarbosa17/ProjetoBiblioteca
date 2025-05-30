<?php

namespace App\Console\Commands;

use App\Models\livro_notificacoes;
use App\Models\requesicoes;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\LivroDisponivel;
use Carbon\Carbon;

class NotificarLivrosDisponiveis extends Command
{
    protected $signature = 'notificar:livros-disponiveis';
    protected $description = 'Notifica os usuários quando os livros são devolvidos hoje';

    public function handle()
    {
        $hoje = Carbon::today()->toDateString();


        $requisicoes = requesicoes::whereDate('data_entrega', $hoje)
            ->with('livro')
            ->get();

        foreach ($requisicoes as $requisicao) {
            $livro = $requisicao->livro;

            $notificacoes = livro_notificacoes::where('livros_id', $livro->id)
                ->where('notificado', false)
                ->with('user')
                ->get();

            foreach ($notificacoes as $notificar) {
                Mail::to($notificar->user->email)->send(new LivroDisponivel($livro));
                $notificar->update(['notificado' => true]);

                $this->info("Notificação enviada para {$notificar->user->email} sobre o livro '{$livro->nome}'");
            }
        }

        return Command::SUCCESS;
    }
}

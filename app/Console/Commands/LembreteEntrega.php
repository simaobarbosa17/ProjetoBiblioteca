<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\requesicoes;
use Illuminate\Support\Facades\Mail;
use App\Mail\LembreteEntrega as LembreteEntregaMail;
use Carbon\Carbon;

class LembreteEntrega extends Command
{
    protected $signature = 'lembrete:entrega';
    protected $description = 'Envia lembretes para usuários que precisam devolver livros amanhã';

    public function handle()
    {
        $amanha = Carbon::tomorrow()->toDateString();

        $requisicoes = requesicoes::with('user')
            ->whereDate('data_entrega', $amanha)
            ->get();

        foreach ($requisicoes as $r) {
            if ($r->user && $r->user->email) {
                Mail::to($r->user->email)->send(new LembreteEntregaMail($r));
                $this->info("Lembrete enviado para {$r->user->email}");
            }
        }

        return Command::SUCCESS;
    }
} 
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Carrinho;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\AlertaCarrinho;

class AlertaCarrinhos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:alerta-carrinhos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $carrinhos = Carrinho::with('livro', 'user')
            ->where('created_at', '<', Carbon::now()->subHour())
            ->where('alerta_enviado', false)
            ->get()
            ->groupBy('user_id');

       
        foreach ($carrinhos as $userId => $itens) {
            $user = $itens->first()->user;


            Mail::to($user->email)->send(new AlertaCarrinho($user, $itens));


            Carrinho::whereIn('id', $itens->pluck('id'))->update(['alerta_enviado' => true]);
        }

        $this->info('E-mails de carrinho abandonado enviados com sucesso.');
    }
}

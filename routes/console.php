<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('notificar:livros-disponiveis')->daily();

Schedule::command('lembrete:entrega')->daily();

Schedule::command('app:alerta-carrinhos')->everyTenMinutes();
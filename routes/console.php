<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('notificar:livros-disponiveis')->everySecond();

Schedule::command('lembrete:entrega')->everySecond();

Schedule::command('app:alerta-carrinhos')->everySecond();

//php artisan schedule:work ou php artisan:nome do command
<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RegistrarLogLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;
        $role = $user->role;

        if ($role === 'admin') {
            app('SiteLogger')(
                'Autenticação',
                $user->id,
                'Administrador logado no sistema.'
            );
        } else {
            app('SiteLogger')(
                'Autenticação',
                $user->id,
                'Cliente logado no sistema.'
            );
        }
    }
}


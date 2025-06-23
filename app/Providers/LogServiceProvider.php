<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
class LogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('SiteLogger', function () {
            return function (string $module, $objectId, string $message) {
                Log::create([
                    'date' => now()->toDateString(),
                    'time' => now()->toTimeString(),
                    'user_id' => Auth::check() ? Auth::id() : null,
                    'module' => $module,
                    'object_id' => $objectId,
                    'change' => $message,
                    'ip_address' => Request::ip(),
                    'browser' => Request::header('User-Agent'),
                ]);
            };
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

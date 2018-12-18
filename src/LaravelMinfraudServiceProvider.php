<?php
namespace LaravelMinfraud;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use LaravelMinfraud\Contracts\MinfraudServiceInterface;
use LaravelMinfraud\Services\MinfraudService;

class LaravelMinfraudServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/minfraud.php' => config_path('minfraud.php'),
        ]);

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function register()
    {
        $this->app->bind(MinfraudServiceInterface::class, function() {
            return new MinfraudService(new Collection(config('minfraud')));
        });
    }
}
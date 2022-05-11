<?php

namespace Remils\LaravelTinkoff;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\ServiceProvider;
use Remils\LaravelTinkoff\Dto\TerminalDto;

class TinkoffProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/tinkoff.php' => config_path('tinkoff.php'),
            ], 'config');
        }
    }

    public function register()
    {
        $this->app->bind('tinkoff', function () {
            return new Tinkoff(
                new TerminalDto(
                    new Collection(
                        config('tinkoff')
                    )
                )
            );
        });
    }
}

<?php

namespace Polashmahmud\History;

use Illuminate\Support\ServiceProvider;

class HistoryTrackingServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}

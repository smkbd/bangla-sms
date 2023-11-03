<?php

namespace Smkbd\BanglaSms;

use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/config/bangla-sms.php', 'bangla-sms');
        $this->publishes([__DIR__.'/config/bangla-sms.php', 'bangla-sms']);
    }

    public function boot(): void
    {

    }
}

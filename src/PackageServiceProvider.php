<?php

namespace Smkbd\BanglaSms;

use Illuminate\Support\ServiceProvider;
use Smkbd\BanglaSms\Provider\Smsq;

class PackageServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/config/bangla-sms.php', 'bangla-sms');
        $this->publishes([
            __DIR__.'/config/bangla-sms.php' => config_path('bangla-sms.php')
        ], 'bangla-sms');
    }

    public function boot(): void
    {

    }
}

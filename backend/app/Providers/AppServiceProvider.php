<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use SocialiteProviders\Steam\Provider;
use App\Models\VirtualMachine;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
    VirtualMachine::class => VirtualMachinePolicy::class,
    ];

   public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Disable SSL verification locally
        if (app()->environment('local')) {
            \Illuminate\Support\Facades\Http::globalOptions([
                'verify' => false,
            ]);
        }

        // Register Steam driver
        Socialite::extend('steam', function ($app) {
        $config = $app['config']['services.steam'];
        
        $provider = new Provider(
            $app['request'],
            $config['client_id'],
            $config['client_secret'],
            $config['redirect']
        );

        // 👇 set Guzzle client after creating the provider
        $provider->setHttpClient(new \GuzzleHttp\Client(['verify' => false]));

        return $provider;
    });
    }
}
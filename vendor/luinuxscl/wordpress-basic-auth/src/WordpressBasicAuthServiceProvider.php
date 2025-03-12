<?php

namespace Luinuxscl\WordpressBasicAuth;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Luinuxscl\WordpressBasicAuth\Livewire\CreateWordpressCredential;

class WordpressBasicAuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/wordpress_basic_auth.php', 'wordpress_basic_auth');
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'wordpress-basic-auth');

        if (class_exists(\Livewire\Livewire::class)) {
            // Register Livewire component directly - works in both v2 and v3
            \Livewire\Livewire::component(
                'create-wordpress-credential',
                \Luinuxscl\WordpressBasicAuth\Livewire\CreateWordpressCredential::class
            );
        }

        if ($this->app->runningInConsole()) {
            $this->commands([
                \Luinuxscl\WordpressBasicAuth\Console\StoreCredentialsCommand::class,
                \Luinuxscl\WordpressBasicAuth\Console\PingWordpressCommand::class,
                \Luinuxscl\WordpressBasicAuth\Console\ListSitesCommand::class,
            ]);

            $this->publishes([
                __DIR__ . '/../config/wordpress_basic_auth.php' =>
                config_path('wordpress_basic_auth.php'),
            ], 'wordpress-basic-auth-config');

            // Publish views
            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/wordpress-basic-auth'),
            ], 'wordpress-basic-auth-views');
        }
    }
}
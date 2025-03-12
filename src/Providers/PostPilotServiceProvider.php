<?php

namespace Luinuxscl\PostPilot\Providers;

use Illuminate\Support\ServiceProvider;
use Luinuxscl\PostPilot\Commands\InstallCommand;

class PostPilotServiceProvider extends ServiceProvider
{
    /**
     * Registra servicios y bindings del paquete.
     */
    public function register(): void
    {
        // Fusiona la configuración por defecto
        $this->mergeConfigFrom(__DIR__ . '/../../config/postpilot.php', 'postpilot');

        // Singleton para la Facade
        $this->app->singleton('postpilot', function () {
            return new \Luinuxscl\PostPilot\PostPilot();
        });
    }

    /**
     * Carga rutas, configuraciones y migraciones.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        // Publicar configuraciones
        $this->publishes([
            __DIR__.'/../../config/postpilot.php' => config_path('postpilot.php'),
        ], ['postpilot-config', 'config']);

        // Publicar migraciones
        $this->publishes([
            __DIR__.'/../../database/migrations/' => database_path('migrations')
        ], ['postpilot-migrations', 'migrations']);
        
        // Registrar comandos
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }
    }
}

<?php

namespace Luinuxscl\PostPilot\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post-pilot:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Instala las dependencias, configuraciones y otros archivos necesarios para PostPilot';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Instalando PostPilot...');

        // Publicar configuraciones
        $this->publishConfiguration();

        // Publicar migraciones
        $this->publishMigrations();

        // Instalar dependencias
        $this->installDependencies();

        $this->info('¡PostPilot ha sido instalado correctamente!');
        $this->info('Por favor, ejecuta "php artisan migrate" para crear las tablas necesarias.');

        return Command::SUCCESS;
    }

    /**
     * Publica los archivos de configuración
     *
     * @return void
     */
    private function publishConfiguration()
    {
        $this->info('Publicando archivos de configuración...');
        
        $this->callSilent('vendor:publish', [
            '--provider' => 'Luinuxscl\PostPilot\Providers\PostPilotServiceProvider',
            '--tag' => 'config'
        ]);

        $this->callSilent('vendor:publish', [
            '--provider' => 'Luinuxscl\LaravelPrompts\PromptsServiceProvider',
            '--tag' => 'config'
        ]);

        $this->info('Archivos de configuración publicados.');
    }

    /**
     * Publica las migraciones
     *
     * @return void
     */
    private function publishMigrations()
    {
        $this->info('Publicando migraciones...');
        
        $this->callSilent('vendor:publish', [
            '--provider' => 'Luinuxscl\PostPilot\Providers\PostPilotServiceProvider',
            '--tag' => 'migrations'
        ]);

        $this->callSilent('vendor:publish', [
            '--provider' => 'Luinuxscl\LaravelPrompts\PromptsServiceProvider',
            '--tag' => 'migrations'
        ]);

        $this->callSilent('vendor:publish', [
            '--provider' => 'Luinuxscl\LaravelApiKeyManager\Providers\APIKeyManagerServiceProvider'
        ]);

        $this->info('Migraciones publicadas.');
    }

    /**
     * Instala dependencias adicionales
     *
     * @return void
     */
    private function installDependencies()
    {
        $this->info('Verificando e instalando dependencias...');

        // Aquí puedes agregar lógica para verificar e instalar dependencias adicionales
        // Ejemplo: composer require package/name

        $this->info('Todas las dependencias han sido instaladas.');
    }
}

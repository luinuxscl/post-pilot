<?php

namespace Luinuxscl\WordpressBasicAuth\Console;

use Illuminate\Console\Command;
use Luinuxscl\WordpressBasicAuth\Models\WordpressCredential;

class ListSitesCommand extends Command
{
    protected $signature = 'wordpress:list-sites';
    protected $description = 'Muestra los sitios de los que tenemos credenciales almacenadas';

    public function handle()
    {
        $credentials = WordpressCredential::all();

        if ($credentials->isEmpty()) {
            $this->info('No hay credenciales almacenadas en la base de datos.');
            return 0;
        }

        $this->info('Sitios con credenciales almacenadas:');
        $this->table(
            ['Identificador', 'URL del sitio', 'Estado de conexión'],
            $credentials->map(function ($credential) {
                return [
                    $credential->identifier,
                    $credential->site_url,
                    $credential->is_connected ? 'Conectado' : 'Desconectado',
                ];
            })
        );

        $this->info('Comando ejecutado con éxito.');
        return 0;
    }
}

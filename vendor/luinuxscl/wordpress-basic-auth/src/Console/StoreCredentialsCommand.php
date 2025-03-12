<?php

namespace Luinuxscl\WordpressBasicAuth\Console;

use Illuminate\Console\Command;
use Luinuxscl\WordpressBasicAuth\Models\WordpressCredential;
use Luinuxscl\WordpressBasicAuth\Services\WordpressService;

class StoreCredentialsCommand extends Command
{
    protected $signature = 'wordpress:store-credentials {identifier} {site_url} {username} {password}';
    protected $description = 'Almacena credenciales de WordPress en la base de datos y verifica conexión';

    public function handle()
    {
        $identifier = $this->argument('identifier');
        $siteUrl = $this->argument('site_url');
        $username = $this->argument('username');
        $password = $this->argument('password');

        $isConnected = WordpressService::checkConnection($siteUrl, $username, $password);

        WordpressCredential::updateOrCreate(
            ['identifier' => $identifier],
            [
                'site_url' => $siteUrl,
                'username' => $username,
                'password' => $password,
                'is_connected' => $isConnected
            ]
        );

        $this->info('Credenciales guardadas correctamente. Conexión: ' . ($isConnected ? 'Exitosa' : 'Fallida'));
    }
}

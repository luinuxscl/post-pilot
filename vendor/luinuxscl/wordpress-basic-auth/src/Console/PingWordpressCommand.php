<?php

namespace Luinuxscl\WordpressBasicAuth\Console;

use Illuminate\Console\Command;
use Luinuxscl\WordpressBasicAuth\Models\WordpressCredential;
use Illuminate\Support\Facades\Http;

class PingWordpressCommand extends Command
{
    protected $signature = 'wordpress:ping {identifier}';
    protected $description = 'Verifica si el sitio WordPress está accesible';

    public function handle()
    {
        $identifier = $this->argument('identifier');
        $credential = WordpressCredential::where('identifier', $identifier)->first();

        if (!$credential) {
            $this->error('No se encontraron credenciales para este identificador.');
            return;
        }

        $response = Http::withBasicAuth($credential->username, $credential->password)->get("{$credential->site_url}/wp-json/wp/v2/posts");

        if ($response->successful()) {
            $credential->update(['is_connected' => true]);
            $this->info("Conexión exitosa con {$credential->site_url}");
        } else {
            $credential->update(['is_connected' => false]);
            $this->error("Error al conectar con {$credential->site_url}: " . $response->status());
        }
    }
}

<?php

namespace Luinuxscl\WordpressBasicAuth\Livewire;

use Livewire\Component;
use Luinuxscl\WordpressBasicAuth\Models\WordpressCredential;
use Illuminate\Support\Facades\Http;

class CreateWordpressCredential extends Component
{
    public $identifier;
    public $site_url;
    public $username;
    public $password;
    public $showModal = false;
    public $showButton = true;
    
    public $is_default = false;

    protected $rules = [
        'identifier' => 'required|string|unique:wordpress_credentials,identifier',
        'site_url' => 'required|url',
        'username' => 'required|string',
        'password' => 'required|string',
        'is_default' => 'boolean',
    ];

    protected $listeners = ['wordpressBasicAuth:openCredentialModal' => 'openModal'];

    public function openModal()
    {
        $this->showModal = true;
    }

    public function create()
    {
        $this->validate();

        // Verificar si ya existe una credencial con el mismo identificador
        if (WordpressCredential::where('identifier', $this->identifier)->exists()) {
            session()->flash('message', __('A credential with this identifier already exists.'));
            return;
        }

        $response = Http::withBasicAuth($this->username, $this->password)->get($this->site_url . '/wp-json');

        if ($response->failed()) {
            session()->flash('message', __('Failed to connect to WordPress site.'));
            return;
        }

        $site_name = $response->json('name');
        $is_connected = $response->successful();

        WordpressCredential::create([
            'identifier' => $this->identifier,
            'site_url' => $this->site_url,
            'username' => $this->username,
            'password' => $this->password,
            'site_name' => $site_name,
            'is_connected' => $is_connected,
        ]);

        $this->reset(['identifier', 'site_url', 'username', 'password', 'is_default', 'showModal']);

        session()->flash('message', 'WordPress credentials created successfully.');
    }

    public function render()
    {
        return view('wordpress-basic-auth::livewire.create-wordpress-credential');
    }
}

<?php

namespace Luinuxscl\PostPilot\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'editorial_line',
        'target_audience',
        'is_default',
        'wordpress_credential_id',
        'user_id',
    ];

    // Relación con User
    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }

    // Relación con WordpressCredential
    public function wordpressCredential()
    {
        return $this->belongsTo(\Luinuxscl\WordpressBasicAuth\Models\WordpressCredential::class);
    }
}

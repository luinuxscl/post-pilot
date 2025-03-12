<?php

namespace Luinuxscl\WordpressBasicAuth\Models;

use Illuminate\Database\Eloquent\Model;

class WordpressCredential extends Model
{
    protected $fillable = ['identifier', 'site_url', 'username', 'password', 'is_connected'];
    protected $hidden = ['password'];
}

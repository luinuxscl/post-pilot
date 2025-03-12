<?php

namespace Luinuxscl\WordpressBasicAuth\Services;

use Luinuxscl\WordpressBasicAuth\Models\WordpressCredential;
use Illuminate\Support\Facades\Http;

class WordpressService
{
    public static function checkConnection($siteUrl, $username, $password)
    {
        $response = Http::withBasicAuth($username, $password)
            ->get("{$siteUrl}/wp-json/wp/v2/users/me");

        return $response->successful();
    }
}

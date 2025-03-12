<?php

namespace Luinuxscl\WordpressBasicAuth\Services;

use Luinuxscl\WordpressBasicAuth\Models\WordpressCredential;
use Illuminate\Support\Facades\Http;

class WordpressPostService
{
    protected function getAuthHeaders($siteUrl)
    {
        $credential = WordpressCredential::where('site_url', $siteUrl)->first();
        if (!$credential) {
            throw new \Exception("No se encontraron credenciales para este sitio.");
        }

        return [
            'Authorization' => 'Basic ' . base64_encode("{$credential->username}:{$credential->password}"),
        ];
    }

    public function getPosts($siteUrl)
    {
        $response = Http::withHeaders($this->getAuthHeaders($siteUrl))
            ->get("{$siteUrl}/wp-json/wp/v2/posts");

        return $response->json();
    }

    public function createPost($siteUrl, $data)
    {
        $response = Http::withHeaders($this->getAuthHeaders($siteUrl))
            ->post("{$siteUrl}/wp-json/wp/v2/posts", $data);

        return $response->json();
    }

    public function updatePost($siteUrl, $postId, $data)
    {
        $response = Http::withHeaders($this->getAuthHeaders($siteUrl))
            ->post("{$siteUrl}/wp-json/wp/v2/posts/{$postId}", $data);

        return $response->json();
    }

    public function deletePost($siteUrl, $postId)
    {
        $response = Http::withHeaders($this->getAuthHeaders($siteUrl))
            ->delete("{$siteUrl}/wp-json/wp/v2/posts/{$postId}");

        return $response->json();
    }
}

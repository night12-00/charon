<?php

namespace App\Services\ApiClients;

class YouTubeClient extends ApiClient
{
    public function getKey(): ?string
    {
        return config('charon.youtube.key');
    }

    public function getSecret(): ?string
    {
        return null;
    }

    public function getEndpoint(): ?string
    {
        return config('charon.youtube.endpoint');
    }
}

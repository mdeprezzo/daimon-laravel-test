<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BreweryService
{
    protected string $baseUrl;

    protected array $headers = [];

    public function __construct()
    {
        $this->baseUrl = config('openbrewerydb.base_url');      
    }

    public function get($path, $params = [], $headers = [])
    {
        $url = $this->baseUrl.$path;
        $response = $this->getHttp($headers)->get($url, $params);

        return $this->packResponse($response);
    }

    private function packResponse(Response $response)
    {
        if ($response->successful()) {
            return $response->json();
        }

        $body = json_decode($response->getBody(), false, 512, JSON_BIGINT_AS_STRING);
        if (isset($body->error) || ! $response->successful()) {
            $error = $body->message ?? $body->error ?? $response->getReasonPhrase();

            throw new HttpException(
                statusCode: $response->getStatusCode(),
                message: $error,
            );
        }
    }  
    
    private function getHttp($headers = [])
    {
        return Http::acceptJson()->withHeaders([...$this->headers, ...$headers]);
    }    
}
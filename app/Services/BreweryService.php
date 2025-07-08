<?php

namespace App\Services;

use App\Services\BaseService;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BreweryService extends BaseService
{
    public function get($path, $params = [], $headers = [])
    {
        $url = $this->baseUrl.$path;
        $response = $this->getHttp($headers)->get($url, $params);

        return $this->packResponse($response);
    }  
}
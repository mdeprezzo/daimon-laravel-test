<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\BreweryService;
use Illuminate\Http\Request;

class BreweryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, BreweryService $service)
    {
        $results = $service->get(
            path: 'breweries',
            params: $request->only(['page', 'per_page'])
        );

        return response()->json($results);
    }
}

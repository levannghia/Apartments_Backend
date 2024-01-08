<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MapController extends Controller
{
    public function autocomplete(Request $request){
        $location = $request->get('location');
        $limit = $request->get('limit');
        $response = Http::get('https://api.locationiq.com/v1/autocomplete', [
            'key' => 'pk.4fd6c26c1af13e9af752d7cd4e4d38de',
            'q' => $location,
            'limit' => $limit,
        ]);

        return $response->json();
    }

    public function search(Request $request){
        $location = $request->get('location');
        $response = Http::get('https://us1.locationiq.com/v1/search', [
            'key' => 'pk.4fd6c26c1af13e9af752d7cd4e4d38de',
            'q' => $location,
            'format' => 'json',
            'addressdetails' => 1,
            'normalizeaddress' => 1
        ]);

        return $response;
    }
}

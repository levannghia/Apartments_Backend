<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertiesResource;
use App\Models\Properties;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PropertiesController extends Controller
{
    public function index(Request $request) {
        $perPage = $request->input('perPage') ?: 10;
        $query = Properties::with(['galleries'])->paginate($perPage);

        $properties = PropertiesResource::collection($query);

        return new JsonResponse([
            'data' => $properties,
        ], 200);
    }
}

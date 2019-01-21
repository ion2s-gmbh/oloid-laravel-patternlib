<?php

namespace Laratomics\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Laratomics\Services\DependenciesService;

class DependenciesController extends Controller
{
    public function get(DependenciesService $dependenciesService)
    {
        return JsonResponse::create([
            'data' => $dependenciesService->getAllGlobals()
        ]);
    }
}

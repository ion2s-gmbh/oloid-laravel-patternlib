<?php

namespace Oloid\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Response;

class ApplicationController extends Controller
{
    /**
     * Get basic information about the main application.
     *
     * @return JsonResponse
     */
    public function info(): JsonResponse
    {
        return Response::json([
            'data' => [
                'appName' => config('app.name')
            ]
        ]);
    }
}

<?php

namespace Oloid\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Oloid\Services\GitService;
use Response;

class ApplicationController extends Controller
{
    /**
     * Get basic information about the main application.
     *
     * @param GitService $gitService
     * @return JsonResponse
     */
    public function info(GitService $gitService): JsonResponse
    {
        return Response::json([
            'data' => [
                'appName' => config('app.name'),
                'currentBranch' => $gitService->getCurrentBranch()
            ]
        ]);
    }
}

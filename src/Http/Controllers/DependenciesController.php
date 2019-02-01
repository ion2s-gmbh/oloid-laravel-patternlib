<?php

namespace Oloid\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Oloid\Http\Requests\GlobalDependencies;
use Oloid\Services\DependenciesService;

class DependenciesController extends Controller
{
    /**
     * @var DependenciesService
     */
    private $dependenciesService;

    /**
     * DependenciesController constructor.
     * @param DependenciesService $dependenciesService
     */
    public function __construct(DependenciesService $dependenciesService)
    {
        $this->dependenciesService = $dependenciesService;
    }

    /**
     * Get all global dependencies
     *
     * @return JsonResponse
     */
    public function get()
    {
        return JsonResponse::create([
            'data' => $this->dependenciesService->getAllGlobals()
        ]);
    }

    /**
     * Store a new global dependency.
     *
     * @param GlobalDependencies $request
     * @return JsonResponse
     */
    public function store(GlobalDependencies $request)
    {
        $headerDependencies = $request->get('head') ?: '';
        $bodyDependencies = $request->get('body') ?: '';
        $this->dependenciesService->storeDependencies($headerDependencies, $bodyDependencies);

        return JsonResponse::create([], JsonResponse::HTTP_CREATED);
    }
}

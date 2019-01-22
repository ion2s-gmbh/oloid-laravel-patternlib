<?php

namespace Laratomics\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laratomics\Services\DependenciesService;

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
     * @param DependenciesService $dependenciesService
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
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $this->dependenciesService->addDependency($request->get('dependency'));

        return JsonResponse::create([], JsonResponse::HTTP_CREATED);
    }

    /**
     * Remove a global dependency.
     *
     * @param Request $request
     */
    public function remove(Request $request)
    {

    }
}

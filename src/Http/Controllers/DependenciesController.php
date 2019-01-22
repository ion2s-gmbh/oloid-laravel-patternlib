<?php

namespace Laratomics\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Laratomics\Services\DependenciesService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $dependency = $request->get('dependency');
        if (!starts_with($dependency, '<link') && !starts_with($dependency, '<script')) {
            throw ValidationException::withMessages([
                'dependency' => 'The dependency is malformed!'
            ]);
        }
        $this->dependenciesService->addDependency($dependency);

        return JsonResponse::create([], JsonResponse::HTTP_CREATED);
    }

    /**
     * Remove a global dependency.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function remove(Request $request)
    {
        /*
         * Check if the dependency exist
         */
        $type = $request->get('type');
        $src = $request->get('url');
        if (!$this->dependenciesService->dependencyExists($type, $src)) {
           throw new NotFoundHttpException('Dependency not found.');
        }

        /*
         * Remove the dependency
         */
        $this->dependenciesService->removeDependency($type, $src);

        return JsonResponse::create([]);
    }
}

<?php

namespace Oloid\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Oloid\Http\Requests\GlobalResource;
use Oloid\Services\ResourcesService;

class ResourcesController extends Controller
{
    /**
     * @var ResourcesService
     */
    private $resourcesService;

    /**
     * ResourcesController constructor.
     * @param ResourcesService $resourcesService
     */
    public function __construct(ResourcesService $resourcesService)
    {
        $this->resourcesService = $resourcesService;
    }

    /**
     * Get all global resources.
     *
     * @return JsonResponse
     */
    public function get()
    {
        return JsonResponse::create([
            'data' => $this->resourcesService->getAll()
        ]);
    }

    /**
     * Store a new global resource.
     *
     * @param GlobalResource $request
     * @return JsonResponse
     */
    public function store(GlobalResource $request)
    {
        $headResource = $request->get('head') ?: '';
        $bodyResource = $request->get('body') ?: '';
        $this->resourcesService->store($headResource, $bodyResource);

        return JsonResponse::create([], JsonResponse::HTTP_CREATED);
    }
}

<?php

namespace Laratomics\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Laratomics\Http\Requests\PatternRequest;
use Laratomics\Http\Resources\PatternResource;
use Laratomics\Services\PatternService;

class PatternController extends Controller
{
    /**
     * @var PatternService
     */
    private $patternService;

    /**
     * PatternController constructor.
     * @param PatternService $patternService
     */
    public function __construct(PatternService $patternService)
    {
        $this->patternService = $patternService;
    }

    /**
     * Store the newly created pattern.
     *
     * @param PatternRequest $request
     * @return PatternResource
     */
    public function store(PatternRequest $request): JsonResponse
    {
        $name = $request->get('name');
        $description = $request->get('description');
        $this->patternService->createPattern($name, $description);

        return JsonResponse::create(new PatternResource([]), JsonResponse::HTTP_CREATED);
    }
}

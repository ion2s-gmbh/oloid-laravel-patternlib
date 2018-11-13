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
     * @return JsonResponse
     */
    public function store(PatternRequest $request): JsonResponse
    {
        $name = $request->get('name');
        $description = $request->get('description');
        $pattern = $this->patternService->createPattern($name, $description);

        return JsonResponse::create(new PatternResource($pattern), JsonResponse::HTTP_CREATED);
    }

    /**
     * Get all information about a Pattern to display it in the workshop.
     *
     * @param string $pattern
     * @return PatternResource
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function preview(string $pattern): PatternResource
    {
        $patternInstance = $this->patternService->loadPattern($pattern);
        return new PatternResource($patternInstance);
    }

    /**
     * Get a rendered html preview of the Pattern.
     *
     * @param string $pattern
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getPreview(string $pattern)
    {
        $pattern = $this->patternService->loadPattern($pattern);
        return view('workshop::preview', [
            'preview' => $pattern->html
        ]);
    }
}

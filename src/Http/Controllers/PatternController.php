<?php

namespace Laratomics\Http\Controllers;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laratomics\Exceptions\RenderingException;
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
        $description = $request->get('description', '');
        $pattern = $this->patternService->createPattern($name, $description);

        return JsonResponse::create(new PatternResource($pattern), JsonResponse::HTTP_CREATED);
    }

    /**
     * Get all information about a Pattern to display it in the workshop.
     *
     * @param string $pattern
     * @return JsonResponse
     * @throws RenderingException
     */
    public function preview(string $pattern): JsonResponse
    {
        try {
            $patternInstance = $this->patternService->loadPattern($pattern);
        } catch (FileNotFoundException $exception) {
            return JsonResponse::create([], JsonResponse::HTTP_NOT_FOUND);
        }
        return JsonResponse::create(new PatternResource($patternInstance));
    }

    /**
     * Get a rendered html preview of the Pattern.
     *
     * @param string $pattern
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws FileNotFoundException
     * @throws RenderingException
     */
    public function getPreview(string $pattern)
    {
        $pattern = $this->patternService->loadPattern($pattern);
        return view('workshop::preview', [
            'preview' => $pattern->html
        ]);
    }

    /**
     * Remove the given Pattern.
     *
     * @param string $pattern
     * @return JsonResponse
     * @throws FileNotFoundException
     */
    public function remove(string $pattern): JsonResponse
    {
        try {
            $this->patternService->remove($pattern);
        } catch (FileNotFoundException $e) {
            return JsonResponse::create([], JsonResponse::HTTP_NOT_FOUND);
        }
        return JsonResponse::create([]);
    }

    public function status(Request $request, string $pattern)
    {
        $newStatus = $request->get('status');
        $this->patternService->updateStatus($newStatus, $pattern);
        return JsonResponse::create([]);
    }

    /**
     * Update an existing Pattern.
     *
     * @param Request $request
     * @param string $pattern
     * @return JsonResponse
     */
    public function update(Request $request, string $pattern): JsonResponse
    {
        return JsonResponse::create([]);
    }

    /**
     * Check if a Pattern already exists.
     *
     * @param string $pattern
     * @return JsonResponse
     */
    public function exists(string $pattern): JsonResponse
    {
        return JsonResponse::create([
            'data' => [
                'exists' => $this->patternService->exists($pattern)
            ]
        ]);
    }
}

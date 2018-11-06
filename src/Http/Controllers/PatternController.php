<?php

namespace Laratomics\Http\Controllers;

use Illuminate\Http\Request;
use Laratomics\Http\Requests\PatternRequest;
use Laratomics\Http\Resources\PatternResource;
use Laratomics\Services\PatternService;
use Illuminate\Routing\Controller;

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
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function store(PatternRequest $request): PatternResource
    {
        $name = $request->get('name');
        $description = $request->get('description');
        $this->patternService->createBladeFile($name);
        $this->patternService->createMarkdownFile($name, $description);
        $this->patternService->createSassFile($name);

        return new PatternResource($this->patternService->loadPattern($name));
    }
}

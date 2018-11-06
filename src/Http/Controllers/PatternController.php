<?php

namespace Laratomics\Http\Controllers;

use Illuminate\Http\Request;
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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $name = $request->get('name');
        $description = $request->get('description');
        $this->patternService->createBladeFile($name);
        $this->patternService->createMarkdownFile($name, $description);
        $this->patternService->createSassFile($name);

//        return redirect(route('preview-pattern', ['pattern' => $name]));
    }
}

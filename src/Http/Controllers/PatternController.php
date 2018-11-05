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
     * Show the creation form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createForm()
    {
        return view('workshop::createPattern');
    }

    /**
     * Store the newly created pattern.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        // TODO: validation and authorization
        $name = $request->get('name');
        $description = $request->get('description');
        $this->patternService->createBladeFile($name);
        $this->patternService->createMarkdownFile($name, $description);
        $this->patternService->createSassFile($name);

        return redirect(route('preview-pattern', ['pattern' => $name]));
    }
}

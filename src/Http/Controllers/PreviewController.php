<?php

namespace Laratomics\Http\Controllers;

use Illuminate\Routing\Controller;
use Laratomics\Services\PatternService;

class PreviewController extends Controller
{
    /**
     * @var PatternService
     */
    private $patternService;

    /**
     * PreviewController constructor.
     * @param PatternService $patternService
     */
    public function __construct(PatternService $patternService)
    {
        $this->patternService = $patternService;
    }

    public function getPreview($pattern)
    {
        list($html, $preview, $metadata, $style, $state) = $this->patternService->loadPattern($pattern);
        return view('workshop::preview', [
            'preview' => $preview
        ]);
    }
}

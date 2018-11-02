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

    public function preview($pattern)
    {
        list($html, $preview, $metadata, $style, $state) = $this->patternService->loadPattern($pattern);

        $explode = explode('.', $pattern);
        $type = substr(array_first($explode), 0, -1);
        array_shift($explode);
        $patternUsage = implode('.', $explode);

        return view('laratomics-workshop::preview', [
            'type' => $type,
            'patternUsage' => $patternUsage,
            'pattern' => $pattern,
            'html' => $html,
            'style' => $style,
            'metadata' => $metadata,
            'preview' => $preview,
            'state' => $state
        ]);
    }

    public function getPreview($pattern)
    {
        list($html, $preview, $metadata, $style, $state) = $this->patternService->loadPattern($pattern);
        return view('getPreview', [
            'preview' => $preview
        ]);
    }
}

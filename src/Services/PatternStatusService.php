<?php


namespace Oloid\Services;


use Illuminate\Support\Facades\Blade;

class PatternStatusService
{
    /**
     * Patterns that are already evaluated.
     * @var array
     */
    protected $evaluatedPatterns = [];

    protected $enabled = false;

    /**
     * Patterns by status.
     * @var array
     */
    protected $patterns = [
        'todo' => [],
        'review' => [],
        'rejected' => [],
        'done' => []
    ];

    /**
     * Get the Patterns by status.
     *
     * @return array
     */
    public function getPatterns(): array
    {
        return $this->patterns;
    }

    /**
     * Evaluate the Pattern's status. Only add the Pattern to the appropriate status once.
     *
     * @param string $pattern
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function evaluate(string $pattern)
    {
        if (!$this->enabled) {
            return;
        }

        /** @var PatternService $patternService */
        $patternService = app()->make(PatternService::class);
        $pattern = $patternService->loadPattern($pattern);

        if (!in_array($pattern->name, $this->patterns[$pattern->status])) {
            $this->patterns[$pattern->status][] = $pattern->name;
        }

        /*
         * If the pattern has not been evaluated yet, trigger a fresh compilation of the pattern's
         * template in order to evaluate nested patterns, too.
         */
        if (!in_array($pattern->name, $this->evaluatedPatterns)) {
            $this->evaluatedPatterns[] = $pattern->name;
            Blade::compileString($pattern->template);
        }
    }

    /**
     * Enable the checking of pattern status.
     */
    public function enable()
    {
        $this->enabled = true;
    }
}
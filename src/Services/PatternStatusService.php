<?php


namespace Oloid\Services;


use Illuminate\Support\Facades\Blade;
use Oloid\Models\Pattern;

class PatternStatusService
{
    /**
     * Patterns that are already evaluated.
     * @var array
     */
    protected $evaluatedPatterns = [];

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
     * @param Pattern $pattern
     */
    public function evaluate(Pattern $pattern)
    {
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
}
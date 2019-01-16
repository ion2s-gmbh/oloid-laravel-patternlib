<?php


namespace Laratomics\Services;


use Laratomics\Models\Pattern;

class PatternStatusService
{
    /**
     * Patterns by status.
     *
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
    }
}
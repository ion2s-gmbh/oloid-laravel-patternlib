<?php


namespace Laratomics\Services;


use Laratomics\Models\Pattern;

class PatternStatusService
{
//    /**
//     * Status counter.
//     *
//     * @var array
//     */
//    protected $counters = [
//        'todo' => 0,
//        'review' => 0,
//        'rejected' => 0,
//        'done' => 0
//    ];

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

//    /**
//     * Get the counter.
//     *
//     * @return array
//     */
//    public function getCounters(): array
//    {
//        return $this->counters;
//    }

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
     * Evaluate the Pattern's status.
     *
     * @param Pattern $pattern
     */
    public function evaluate(Pattern $pattern)
    {
//        $this->incrementCounter($pattern->status);
        $this->patterns[$pattern->status][] = $pattern->name;
    }

//    /**
//     * Increment the counter.
//     *
//     * @param string $name
//     */
//    private function incrementCounter(string $name)
//    {
//        $this->counters[$name]++;
//    }
}
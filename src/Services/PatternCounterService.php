<?php


namespace Laratomics\Services;


class PatternCounterService
{
    protected $counters = [
        'todo' => 0,
        'review' => 0,
        'rejected' => 0,
        'done' => 0
    ];

    /**
     * @return array
     */
    public function getCounters(): array
    {
        return $this->counters;
    }

    public function incrementCounter(string $name)
    {
        $this->counters[$name]++;
    }
}
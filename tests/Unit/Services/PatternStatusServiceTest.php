<?php

namespace Unit\Services;

use Laratomics\Models\Pattern;
use Laratomics\Services\PatternStatusService;
use Tests\BaseTestCase;
use Tests\Traits\TestStubs;

class PatternStatusServiceTest extends BaseTestCase
{
    use TestStubs;

    /**
     * @test
     * @covers \Laratomics\Services\PatternStatusService
     */
    public function it_should_get_the_patterns_by_status()
    {
        // arrange
        $pattern = new Pattern();
        $pattern->name = 'atoms.text.h1';
        $pattern->status = 'rejected';

        $cut = new PatternStatusService();

        $expected = [
            'todo' => [],
            'review' => [],
            'rejected' => [],
            'done' => [],
        ];

        // assert
        $this->assertEquals($expected, $cut->getPatterns());
    }

    /**
     * @test
     * @covers \Laratomics\Services\PatternStatusService
     */
    public function it_should_evaluate_a_patterns_status()
    {
        // arrange
        $pattern = new Pattern();
        $pattern->name = 'atoms.text.h1';
        $pattern->status = 'rejected';

        $cut = new PatternStatusService();

        $expected = [
            'todo' => [],
            'review' => [],
            'rejected' => ['atoms.text.h1'],
            'done' => [],
        ];

        $cut->evaluate($pattern);
        $this->assertEquals($expected, $cut->getPatterns());
    }
}

<?php

namespace Unit\Services;

use Oloid\Models\Pattern;
use Oloid\Services\PatternStatusService;
use Tests\BaseTestCase;
use Tests\Traits\TestStubs;

class PatternStatusServiceTest extends BaseTestCase
{
    use TestStubs;

    /**
     * @test
     * @covers \Oloid\Services\PatternStatusService
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
     * @covers \Oloid\Services\PatternStatusService
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

        $cut->enable();
        $cut->evaluate($pattern->name);
        $this->assertEquals($expected, $cut->getPatterns());
    }

    /**
     * @test
     * @covers \Oloid\Services\PatternStatusService
     */
    public function it_should_only_list_a_pattern_once()
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

        /*
         * Evaluate first occurrence of the pattern in an other pattern
         */
        $cut->evaluate($pattern);

        /*
         * Evaluate second occurrence of the pattern in an other pattern
         */
        $cut->evaluate($pattern);

        $this->assertEquals($expected, $cut->getPatterns());
    }
}

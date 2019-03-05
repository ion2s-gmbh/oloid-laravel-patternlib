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
        $this->preparePatternStub();

        $cut = new PatternStatusService();

        $expected = [
            'todo' => [],
            'review' => [],
            'rejected' => ['atoms.text.headline2'],
            'done' => [],
        ];

        $cut->enable();
        $cut->evaluate('atoms.text.headline2');
        $this->assertEquals($expected, $cut->getPatterns());
    }

    /**
     * @test
     * @covers \Oloid\Services\PatternStatusService
     */
    public function it_should_only_list_a_pattern_once()
    {
        // arrange
        $this->preparePatternStub();
        $name = 'atoms.text.headline2';

        $cut = new PatternStatusService();

        $expected = [
            'todo' => [],
            'review' => [],
            'rejected' => ['atoms.text.headline2'],
            'done' => [],
        ];

        $cut->enable();

        /*
         * Evaluate first occurrence of the pattern in an other pattern
         */
        $cut->evaluate($name);

        /*
         * Evaluate second occurrence of the pattern in an other pattern
         */
        $cut->evaluate($name);

        $this->assertEquals($expected, $cut->getPatterns());
    }

    /**
     * @test
     * @covers \Oloid\Services\PatternStatusService
     */
    public function it_should_not_run_evaluation_if_not_enabled()
    {
        // arrange
        $this->preparePatternStub();
        $cut = new PatternStatusService();

        $expected = [
            'todo' => [],
            'review' => [],
            'rejected' => [],
            'done' => [],
        ];

        $cut->evaluate('atoms.text.headline2');

        $this->assertEquals($expected, $cut->getPatterns());
    }

    /**
     * @test
     * @covers \Oloid\Services\PatternStatusService
     */
    public function it_should_enable_the_evaluation()
    {
        // arrange
        $cut = new PatternStatusService();

        // assert
        $this->assertFalse($cut->isEnabled());
        $cut->enable();
        $this->assertTrue($cut->isEnabled());
    }
}

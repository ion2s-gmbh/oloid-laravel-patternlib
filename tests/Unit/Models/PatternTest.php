<?php

namespace Unit;

use Laratomics\Models\Pattern;
use Tests\BaseTestCase;

class PatternTest extends BaseTestCase
{
    /**
     * @test
     * @covers \Laratomics\Models\Pattern
     */
    public function it_should_get_the_pattern_type()
    {
        $pattern = new Pattern();
        $pattern->name = 'atoms.buttons.submit';
        $this->assertEquals('atoms', $pattern->getType());
    }

    /**
     * @test
     * @covers \Laratomics\Models\Pattern
     */
    public function it_should_get_the_patterns_name_without_the_type()
    {
        $pattern = new Pattern();
        $pattern->name = 'atoms.buttons.submit';
        $this->assertEquals('buttons.submit', $pattern->getNameWithoutType());
    }
}

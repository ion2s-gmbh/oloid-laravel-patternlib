<?php

namespace Unit\Rules;

use Oloid\Rules\UniquePattern;
use Tests\BaseTestCase;
use Tests\Traits\TestStubs;

class UniquePatternTest extends BaseTestCase
{
    use TestStubs;

    /**
     * @test
     * @covers \Oloid\Rules\UniquePattern
     */
    public function it_should_pass_the_validation()
    {
        // arrange
        $rule = new UniquePattern();

        // assert
        $this->assertTrue($rule->passes('name', 'atoms.text.headline1'));
    }

    /**
     * @test
     * @covers \Oloid\Rules\UniquePattern
     */
    public function it_should_fail_the_validation()
    {
        // arrange
        $rule = new UniquePattern();
        $this->preparePatternStub();

        // assert
        $this->assertFalse($rule->passes('name', 'atoms.text.headline1'));
        $this->assertEquals("The pattern ':attribute' must be unique!", $rule->message());
    }
}

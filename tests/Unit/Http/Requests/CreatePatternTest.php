<?php

namespace Tests\Unit\Http\Requests;


use Laratomics\Http\Requests\CreatePattern;
use Laratomics\Rules\UniquePattern;
use Laratomics\Tests\BaseTestCase;

class CreatePatternTest extends BaseTestCase
{
    /**
     * @var CreatePattern
     */
    private $cut;

    protected function setUp()
    {
        parent::setUp();
        $this->cut = new CreatePattern();
    }

    /**
     * @test
     * @covers \Laratomics\Http\Requests\CreatePattern
     */
    public function it_should_always_be_authorized()
    {
        $this->assertTrue($this->cut->authorize());
    }

    /**
     * @test
     * @covers \Laratomics\Http\Requests\CreatePattern
     */
    public function it_should_contain_validation_rules()
    {
        // arrange
        $rules = [
            'name' => ['required', new UniquePattern]
        ];

        $this->assertEquals($rules, $this->cut->rules());
    }
}

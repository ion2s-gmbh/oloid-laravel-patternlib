<?php

namespace Unit\Http\Requests;


use Oloid\Http\Requests\CreatePattern;
use Oloid\Rules\UniquePattern;
use Tests\BaseTestCase;

class CreatePatternTest extends BaseTestCase
{
    /**
     * @var CreatePattern
     */
    private $cut;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cut = new CreatePattern();
    }

    /**
     * @test
     * @covers \Oloid\Http\Requests\CreatePattern
     */
    public function it_should_always_be_authorized()
    {
        $this->assertTrue($this->cut->authorize());
    }

    /**
     * @test
     * @covers \Oloid\Http\Requests\CreatePattern
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

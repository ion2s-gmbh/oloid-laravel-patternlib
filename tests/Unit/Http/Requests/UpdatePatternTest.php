<?php

namespace Tests\Unit\Http\Requests;


use Laratomics\Http\Requests\UpdatePattern;
use Laratomics\Rules\UniquePattern;
use Laratomics\Tests\BaseTestCase;

class UpdatePatternTest extends BaseTestCase
{
    /**
     * @var UpdatePattern
     */
    private $cut;

    protected function setUp()
    {
        parent::setUp();
        $this->cut = new UpdatePattern();
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
            'name' => ['sometimes', 'required', new UniquePattern]
        ];

        $this->assertEquals($rules, $this->cut->rules());
    }
}

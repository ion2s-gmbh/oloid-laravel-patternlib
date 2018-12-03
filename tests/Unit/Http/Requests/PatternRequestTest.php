<?php

namespace Tests\Unit\Http\Requests;


use Laratomics\Http\Requests\PatternRequest;
use Laratomics\Rules\UniquePattern;
use Laratomics\Tests\BaseTestCase;

class PatternRequestTest extends BaseTestCase
{
    /**
     * @var PatternRequest
     */
    private $cut;

    protected function setUp()
    {
        parent::setUp();
        $this->cut = new PatternRequest();
    }

    /**
     * @test
     * @covers \Laratomics\Http\Requests\PatternRequest
     */
    public function it_should_always_be_authorized()
    {
        $this->assertTrue($this->cut->authorize());
    }

    /**
     * @test
     * @covers \Laratomics\Http\Requests\PatternRequest
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

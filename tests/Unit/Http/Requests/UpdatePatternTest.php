<?php

namespace Unit\Http\Requests;


use Oloid\Http\Requests\UpdatePattern;
use Oloid\Rules\UniquePattern;
use Tests\BaseTestCase;

class UpdatePatternTest extends BaseTestCase
{
    /**
     * @var UpdatePattern
     */
    private $cut;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cut = new UpdatePattern();
    }

    /**
     * @test
     * @covers \Oloid\Http\Requests\UpdatePattern
     */
    public function it_should_always_be_authorized()
    {
        $this->assertTrue($this->cut->authorize());
    }

    /**
     * @test
     * @covers \Oloid\Http\Requests\UpdatePattern
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

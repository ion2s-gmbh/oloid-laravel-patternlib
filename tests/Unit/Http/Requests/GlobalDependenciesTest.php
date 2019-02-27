<?php

namespace Unit\Http\Requests;


use Oloid\Http\Requests\GlobalResource;
use Tests\BaseTestCase;

class GlobalDependenciesTest extends BaseTestCase
{
    /**
     * @var \Oloid\Http\Requests\GlobalResource
     */
    private $cut;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cut = new GlobalResource();
    }

    /**
     * @test
     * @covers \Oloid\Http\Requests\GlobalResource
     */
    public function it_should_always_be_authorized()
    {
        $this->assertTrue($this->cut->authorize());
    }

    /**
     * @test
     * @covers \Oloid\Http\Requests\GlobalResource
     */
    public function it_should_contain_validation_rules()
    {
        // arrange
        $rules = [
            'head' => 'present',
            'body' => 'present'
        ];

        $this->assertEquals($rules, $this->cut->rules());
    }
}

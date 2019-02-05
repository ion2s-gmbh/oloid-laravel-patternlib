<?php

namespace Unit\Http\Requests;


use Oloid\Http\Requests\GlobalDependencies;
use Tests\BaseTestCase;

class GlobalDependenciesTest extends BaseTestCase
{
    /**
     * @var \Oloid\Http\Requests\GlobalDependencies
     */
    private $cut;

    protected function setUp()
    {
        parent::setUp();
        $this->cut = new GlobalDependencies();
    }

    /**
     * @test
     * @covers \Oloid\Http\Requests\GlobalDependencies
     */
    public function it_should_always_be_authorized()
    {
        $this->assertTrue($this->cut->authorize());
    }

    /**
     * @test
     * @covers \Oloid\Http\Requests\GlobalDependencies
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

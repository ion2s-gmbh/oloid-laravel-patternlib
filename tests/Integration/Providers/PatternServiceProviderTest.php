<?php

namespace Tests\Integration\Providers;

use Laratomics\Tests\BaseTestCase;
use Laratomics\Tests\Traits\TestStubs;

class PatternServiceProviderTest extends BaseTestCase
{
    use TestStubs;

    /**
     * @test
     * @covers \Laratomics\Providers\PatternServiceProvider
     */
    public function it_should_use_a_pattern_with_include()
    {
        // arrange
        $this->preparePatternStub();

        // act
        $response = $this->get("/workshop/testing/include");

        // assert
        $response->assertSuccessful();
        $response->assertViewIs('workshop::testing.include');
        $response->assertSee('INCLUDE');
    }

    /**
     * @test
     * @covers \Laratomics\Providers\PatternServiceProvider
     */
    public function it_should_use_a_pattern_with_atom()
    {
        // arrange
        $this->preparePatternStub();

        // act
        $response = $this->get("/workshop/testing/atom");

        // assert
        $response->assertSuccessful();
        $response->assertViewIs('workshop::testing.atom');
        $response->assertSee('ATOM');
    }

}

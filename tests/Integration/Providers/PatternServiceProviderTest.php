<?php

namespace Integration\Providers;

use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Facades\Blade;
use Laratomics\Providers\PatternServiceProvider;
use Tests\BaseTestCase;
use Tests\Traits\TestStubs;

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
        /** @var TestResponse $response */
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
        /** @var TestResponse $response */
        $response = $this->get("/workshop/testing/atom");

        // assert
        $response->assertSuccessful();
        $response->assertViewIs('workshop::testing.atom');
        $response->assertSee('ATOM');
    }

    /**
     * @test
     * @covers \Laratomics\Providers\PatternServiceProvider
     */
    public function it_should_register_component_directives()
    {
        // arrange
        $this->preparePatternStub();

        // act
        $patternServiceProvider = new PatternServiceProvider(app());
        $patternServiceProvider->boot();

        // assert
        $this->assertCount(1, Blade::getCustomDirectives());
    }

    /**
     * @test
     * @covers \Laratomics\Providers\PatternServiceProvider
     */
    public function it_should_not_register_component_directives()
    {
        // arrange

        // act
        $patternServiceProvider = new PatternServiceProvider(app());
        $patternServiceProvider->boot();

        // assert
        $this->assertCount(0, Blade::getCustomDirectives());
    }

    /**
     * @test
     * @covers \Laratomics\Providers\PatternServiceProvider
     */
    public function it_should_return_the_callable_handler_for_blade_directive()
    {
        // arrange
        $patternServiceProvider = new PatternServiceProvider(app());
        $closure = $patternServiceProvider->directiveResolution('atoms');
        $expected = "<?php echo view('patterns.atoms.headline.one', ['text' => 'Heading 1'], array_except(get_defined_vars(), array('__data', '__path')))->render() ?>";

        // act
        $parsed = $closure->call($patternServiceProvider, "'headline.one', ['text' => 'Heading 1']");

        // assert
        $this->assertTrue(is_callable($closure));
        $this->assertEquals($expected, $parsed);

    }
}

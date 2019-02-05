<?php

namespace Integration\Providers;

use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Facades\Blade;
use Oloid\Providers\PatternServiceProvider;
use Tests\BaseTestCase;
use Tests\Traits\TestStubs;

class PatternServiceProviderTest extends BaseTestCase
{
    use TestStubs;

    /**
     * @test
     * @covers \Oloid\Providers\PatternServiceProvider
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
     * @covers \Oloid\Providers\PatternServiceProvider
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
     * @covers \Oloid\Providers\PatternServiceProvider
     */
    public function it_should_register_component_directives()
    {
        // arrange
        $this->preparePatternStub();

        // act
        $patternServiceProvider = new PatternServiceProvider(app());
        $patternServiceProvider->boot();

        // assert
        $this->assertCount(2, Blade::getCustomDirectives());
    }

    /**
     * @test
     * @covers \Oloid\Providers\PatternServiceProvider
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
     * @covers \Oloid\Providers\PatternServiceProvider
     */
    public function it_should_return_the_callable_handler_for_blade_directive()
    {
        // arrange
        $this->preparePatternStub();
        $patternServiceProvider = new PatternServiceProvider(app());
        $closure = $patternServiceProvider->directiveResolution('atoms');
        $expected = "<?php echo view('patterns.atoms.text.headline1', ['text' => 'Heading 1'], array_except(get_defined_vars(), array('__data', '__path')))->render() ?>";

        // act
        $parsed = $closure->call($patternServiceProvider, "'text.headline1', ['text' => 'Heading 1']");

        // assert
        $this->assertTrue(is_callable($closure));
        $this->assertEquals($expected, $parsed);

    }
}

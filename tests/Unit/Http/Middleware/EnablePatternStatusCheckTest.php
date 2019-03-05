<?php

namespace Unit\Http\Requests;


use Illuminate\Http\Request;
use Mockery;
use Oloid\Http\Middleware\EnablePatternStatusCheck;
use Oloid\Http\Requests\CreatePattern;
use Oloid\Services\PatternStatusService;
use Tests\BaseTestCase;

class EnablePatternStatusCheckTest extends BaseTestCase
{
    /**
     * @var CreatePattern
     */
    private $cut;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cut = new EnablePatternStatusCheck();
    }

    /**
     * @test
     * @covers \Oloid\Http\Middleware\EnablePatternStatusCheck
     */
    public function it_should_enable_the_pattern_status_check()
    {
        // prepare
        $requestMock = Mockery::mock(Request::class);

        /** @var PatternStatusService $patternStatusService */
        $patternStatusService = app()->make(PatternStatusService::class);

        $this->assertFalse($patternStatusService->isEnabled());

        $this->cut->handle($requestMock, function () {
            return true;
        });

        $this->assertTrue($patternStatusService->isEnabled());
    }
}

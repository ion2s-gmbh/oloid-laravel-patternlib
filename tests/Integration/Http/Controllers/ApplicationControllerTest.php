<?php

namespace Integration\Http\Controllers;

use Mockery;
use Oloid\Services\GitService;
use Tests\BaseTestCase;

class ApplicationControllerTest extends BaseTestCase
{
    /**
     * @test
     * @covers \Oloid\Http\Controllers\ApplicationController
     */
    public function it_should_get_info_about_the_app_name()
    {
        $gitServiceMock = Mockery::mock(GitService::class);
        $gitServiceMock->shouldReceive('getCurrentBranch')
            ->andReturn('testing-branch');

        $this->app->bind(GitService::class, function ($app) use ($gitServiceMock) {
            return $gitServiceMock;
        });

        $this->getJson('workshop/api/v1/info')
            ->assertSuccessful()
            ->assertJsonFragment([
                'data' => [
                    'appName' => 'testApp',
                    'currentBranch' => 'testing-branch'
                ]
            ]);
    }
}

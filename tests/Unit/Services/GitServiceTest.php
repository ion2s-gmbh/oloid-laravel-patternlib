<?php

namespace Unit\Services;

use Illuminate\Filesystem\Filesystem;
use Mockery;
use Oloid\Services\GitService;
use Tests\BaseTestCase;

class GitServiceTest extends BaseTestCase
{
    /**
     * @test
     * @covers \Oloid\Services\GitService
     */
    public function it_should_return_no_branch_without_git()
    {
        // arrange
        $fileSystemMock = Mockery::mock(Filesystem::class);
        $fileSystemMock->shouldReceive('exists')
            ->with(base_path('../.git'))
            ->andReturnFalse();

        $this->app->bind(Filesystem::class, function ($app) use ($fileSystemMock) {
            return $fileSystemMock;
        });

        // act
        /** @var GitService $cut */
        $cut = app(GitService::class);


        // assert
        $this->assertEquals('No git repo', $cut->getCurrentBranch());
    }

    /**
     * @test
     * @covers \Oloid\Services\GitService
     */
    public function it_should_return_current_git_branch()
    {
        // arrange
        $fileSystemMock = Mockery::mock(Filesystem::class);
        $fileSystemMock->shouldReceive('exists')
            ->with(base_path('../.git'))
            ->andReturnTrue();

        $this->app->bind(Filesystem::class, function ($app) use ($fileSystemMock) {
            return $fileSystemMock;
        });

        // act
        /** @var GitService $cut */
        $cut = app(GitService::class);

        // assert
        $currentBranch = $cut->getCurrentBranch();
        $this->assertNotNull($currentBranch);
        $this->assertNotEmpty($currentBranch);
        $this->assertNotEquals('No git repo', $currentBranch);
    }
}

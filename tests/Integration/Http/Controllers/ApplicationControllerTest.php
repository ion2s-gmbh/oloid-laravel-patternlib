<?php

namespace Tests\Integration\Http\Controllers;

use Laratomics\Tests\BaseTestCase;

class ApplicationControllerTest extends BaseTestCase
{
    /**
     * @test
     * @covers \Laratomics\Http\Controllers\ApplicationController
     */
    public function it_should_get_info_about_the_app_name()
    {
        $this->getJson('workshop/api/v1/info')
            ->assertSuccessful()
            ->assertJsonFragment([
                'data' => [
                    'appName' => 'testApp'
                ]
            ]);
    }
}

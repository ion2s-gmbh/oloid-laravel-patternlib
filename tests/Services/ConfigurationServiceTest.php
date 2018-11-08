<?php

namespace Tests\Unit\Services;

use Illuminate\Filesystem\Filesystem;
use Laratomics\Services\ConfigurationService;
use Laratomics\Tests\BaseTestCase;

class ConfigurationServiceTest extends BaseTestCase
{
    /**
     * @var ConfigurationService
     */
    private $cut;

    protected function setUp()
    {
        parent::setUp();
//        $this->cut = new ConfigurationService();
    }


    /**
     * @test
     * @covers \Laratomics\Services\ConfigurationService
     */
    public function it_should_add_extra_laratomics_path_to_view_config()
    {
        // arrange
//        $fs = new Filesystem();
//        $sourcePath = realpath(__DIR__ . '/../stubs/view.php');
//        $configPath = "{$this->tempDir}/view.php";
//        $fs->copy($sourcePath, $configPath);

        // act
//        $this->cut->registerViewResources($configPath);


        // assert
        // TODO: implement

    }

}

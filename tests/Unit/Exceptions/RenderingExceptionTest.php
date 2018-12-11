<?php

namespace Unit\Exceptions;

use Exception;
use Laratomics\Exceptions\RenderingException;
use Tests\BaseTestCase;

class RenderingExceptionTest extends BaseTestCase
{
    /**
     * @test
     * @covers \Laratomics\Exceptions\RenderingException
     */
    public function it_should_create_a_new_RenderingException()
    {
        $e = new Exception('Test Exception');
        $cut = new RenderingException('Rendering Exception', 0, $e);

        $this->assertEquals('Preview rendering failed', $cut->getMessage());
        $this->assertEquals(0, $cut->getCode());
        $this->assertSame($e, $cut->getPrevious());
    }
}

<?php

namespace Oncesk\LogReader\Tests\Unit\SourceLog;

use Oncesk\LogReader\SourceLog\FileResource;
use PHPUnit\Framework\TestCase;

class FileResourceTest extends TestCase
{
    public function testGetResource()
    {
        $resource = fopen('php://input', 'r');
        $subject = new FileResource($resource);
        $this->assertEquals($resource, $subject->getResource());
        fclose($resource);

        $subject = new FileResource('test');
        $this->expectException(\RuntimeException::class);
        $subject->getResource();
    }
}

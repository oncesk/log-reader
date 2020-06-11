<?php

namespace Oncesk\LogReader\Tests\Unit\Record;

use Oncesk\LogReader\Record\LineSplitter;
use PHPUnit\Framework\TestCase;

class LineSplitterTest extends TestCase
{
    /**
     * @param string $line
     * @param string $delimiter
     * @param array $result
     * @dataProvider dataProvider
     */
    public function testSplit(string $line, string $delimiter, array $result)
    {
        $splitter = new LineSplitter();
        $this->assertEquals($result, $splitter->split($line, $delimiter));
    }

    public function dataProvider()
    {
        return [
            ['/index/1 122.232.112.333', ' ', ['/index/1', '122.232.112.333']],
            ["/index/1 122.232.112.333\n", ' ', ['/index/1', '122.232.112.333']],
            ["/index/1;122.232.112.333\n", ';', ['/index/1', '122.232.112.333']],
        ];
    }
}

<?php

namespace Oncesk\LogReader\Tests\Unit\SourceLog;

use Oncesk\LogReader\SourceLog\SourceDeterminer;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputInterface;

class SourceDeterminerTest extends TestCase
{
    /**
     * @var InputInterface|MockObject
     */
    private $input;

    protected function setUp(): void
    {
        $this->input = $this->getMockBuilder(InputInterface::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
    }

    /**
     * @dataProvider dataProvider
     * @param $stdin
     * @param $option
     * @param $argument
     * @param $result
     */
    public function testDetermine($stdin, $option, $argument, $result)
    {
        $this->input
            ->method('getOption')
            ->willReturn($option);
        $this->input
            ->method('getArgument')
            ->willReturn($argument);

        $subject = new SourceDeterminer($stdin);
        if (!$option && !$argument) {
            $this->expectException(\RuntimeException::class);
        }
        $this->assertEquals($subject->determine($this->input), $result);
    }

    public function dataProvider()
    {
        return [
            ['php://input', true, false, 'php://input'],
            ['php://input', false, '/tmp/file', '/tmp/file'],
            ['php://input', false, '/tmp/file', '/tmp/file'],
            ['php://input', false, false, '']
        ];
    }
}

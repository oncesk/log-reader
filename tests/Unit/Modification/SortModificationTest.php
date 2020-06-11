<?php

namespace Oncesk\LogReader\Tests\Unit\Modification;

use Oncesk\LogReader\Modification\ModificationInterface;
use Oncesk\LogReader\Modification\SortModification;
use Oncesk\LogReader\Record\RecordSet;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputInterface;

class SortModificationTest extends TestCase
{
    /**
     * @var InputInterface|MockObject
     */
    private $input;

    /**
     * @var SortModification|ModificationInterface
     */
    private $subject;

    protected function setUp(): void
    {
        $this->input = $this->getMockBuilder(InputInterface::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $this->subject = new SortModification($this->input);
    }

    /**
     * @dataProvider applicableDataProvider
     */
    public function testIsApplicable($expected, $return)
    {
        $this->input
            ->method('getOption')
            ->willReturn($return);
        $this->assertEquals($expected, $this->subject->isApplicable($this->input));
    }

    /**
     * @dataProvider applyDataProvider
     */
    public function testApply($sourceSet, $order, $resultSet)
    {
        $this->input
            ->method('getOption')
            ->will($this->onConsecutiveCalls(
                'count', $order
            ));

        $set = new RecordSet($sourceSet);
        $this->assertEquals($resultSet, $this->subject->apply($set)->toArray());
    }

    public function applyDataProvider()
    {
        return [
            [
                [['count' => 2], ['count' => 3], ['count' => 1]],
                'desc',
                [['count' => 3], ['count' => 2], ['count' => 1]],
            ],
            [
                [['count' => 2], ['count' => 3], ['count' => 1]],
                'asc',
                [['count' => 1], ['count' => 2], ['count' => 3]],
            ],
            [
                [['count' => 2], ['count' => 3], ['count' => 1]],
                null,
                [['count' => 1], ['count' => 2], ['count' => 3]],
            ]
        ];
    }

    public function applicableDataProvider()
    {
        return [
            [false, null],
            [false, false],
            [false, ''],
            [true, 'path']
        ];
    }
}

<?php

namespace Oncesk\LogReader\Tests\Unit\Modification;

use Oncesk\LogReader\Modification\GroupModification;
use Oncesk\LogReader\Modification\ModificationInterface;
use Oncesk\LogReader\Record\RecordSet;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputInterface;

class GroupModificationTest extends TestCase
{
    /**
     * @var InputInterface|MockObject
     */
    private $input;

    /**
     * @var ModificationInterface
     */
    private $subject;

    protected function setUp(): void
    {
        $this->input = $this->getMockBuilder(InputInterface::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $this->subject = new GroupModification($this->input);
    }

    /**
     * @dataProvider applyDataProvider
     * @param $source
     * @param $result
     * @param $columns
     */
    public function testApply($source, $result, $columns)
    {
        $this->input
            ->method('getOption')
            ->will($this->onConsecutiveCalls($columns, 'cnt'));

        $this->assertEquals($result, $this->subject->apply(new RecordSet($source))->toArray());
    }

    public function applyDataProvider()
    {
        return [
            [
                [
                    ['path' => '/index'],
                    ['path' => '/index'],
                    ['path' => '/contact'],
                    ['path' => '/shop'],
                    ['path' => '/shop'],
                    ['path' => '/index'],
                ],
                [
                    ['path' => '/index', 'path_cnt' => 3],
                    ['path' => '/contact', 'path_cnt' => 1],
                    ['path' => '/shop', 'path_cnt' => 2],
                ],
                ['path']
            ],
            [
                [
                    ['path' => '/index', 'ip' => '1.1'],
                    ['path' => '/index', 'ip' => '1.2'],
                    ['path' => '/contact', 'ip' => '2.2'],
                    ['path' => '/shop', 'ip' => '2.3'],
                    ['path' => '/shop', 'ip' => '1.1'],
                    ['path' => '/index', 'ip' => '1.1'],
                ],
                [
                    ['path' => '/index', 'path_cnt' => 3, 'ip' => '1.1', 'ip_cnt' => 2],
                    ['path' => '/index', 'path_cnt' => 3, 'ip' => '1.2', 'ip_cnt' => 1],
                    ['path' => '/contact', 'path_cnt' => 1, 'ip' => '2.2', 'ip_cnt' => 1],
                    ['path' => '/shop', 'path_cnt' => 2, 'ip' => '2.3', 'ip_cnt' => 1],
                    ['path' => '/shop', 'path_cnt' => 2, 'ip' => '1.1', 'ip_cnt' => 1],
                ],
                ['path', 'ip']
            ]
        ];
    }
}

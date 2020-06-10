<?php

namespace Oncesk\LogReader\Record;

use Symfony\Component\Console\Input\InputInterface;

class RecordFactory implements RecordFactoryInterface
{
    /**
     * @var ColumnDefinitionInterface
     */
    private $definition;

    /**
     * @var LineSplitterInterface
     */
    private $lineSplitter;

    /**
     * @var ColumnDataMapperInterface
     */
    private $dataMapper;

    /**
     * @var InputInterface
     */
    private $input;

    /**
     * RecordFactory constructor.
     * @param ColumnDefinitionInterface $definition
     * @param LineSplitterInterface $lineSplitter
     * @param ColumnDataMapperInterface $dataMapper
     * @param InputInterface $input
     */
    public function __construct(
        ColumnDefinitionInterface $definition,
        LineSplitterInterface $lineSplitter,
        ColumnDataMapperInterface $dataMapper,
        InputInterface $input
    ) {
        $this->definition = $definition;
        $this->lineSplitter = $lineSplitter;
        $this->dataMapper = $dataMapper;
        $this->input = $input;
    }

    /**
     * @param string $line
     * @return RecordInterface|array
     */
    public function createRecord(string $line): RecordInterface
    {
        return new Record(
            $this->dataMapper->map(
                $this->definition,
                $this->lineSplitter->split($line, $this->input->getOption('delimiter'))
            )
        );
    }
}

<?php

namespace Oncesk\LogReader\Output;

use Oncesk\LogReader\Record\ColumnDefinitionInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FormattedRecordOutputWriter implements RecordOutputWriterInterface
{
    /**
     * @var ColumnDefinitionInterface
     */
    private $columnDefinition;

    /**
     * FormattedRecordOutputWriter constructor.
     * @param ColumnDefinitionInterface $columnDefinition
     */
    public function __construct(ColumnDefinitionInterface $columnDefinition)
    {
        $this->columnDefinition = $columnDefinition;
    }

    /**
     * @param array $record
     * @param OutputInterface $output
     */
    public function write(array $record, OutputInterface $output)
    {
        $output->writeln(
            $this->parseFormat($this->columnDefinition->getFormat(), $record)
        );
    }

    /**
     * @param string $format
     * @param array $data
     * @return mixed|string
     */
    private function parseFormat(string $format, array $data)
    {
        // todo create abstraction, move to standalone class
        foreach ($data as $k => $v) {
            $format = str_replace('{{ ' . $k . ' }}', $v, $format);
        }
        return $format;
    }
}

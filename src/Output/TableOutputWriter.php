<?php

namespace Oncesk\LogReader\Output;

use Oncesk\LogReader\Record\ArrayConvertableInterface;
use Oncesk\LogReader\Record\ColumnDefinitionInterface;
use Oncesk\LogReader\Record\RecordInterface;
use Oncesk\LogReader\Record\RecordSetInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Output\OutputInterface;

class TableOutputWriter implements OutputWriterInterface
{
    /**
     * @var ColumnDefinitionInterface
     */
    private $columnDefinition;

    /**
     * TableOutputWriter constructor.
     * @param ColumnDefinitionInterface $columnDefinition
     */
    public function __construct(ColumnDefinitionInterface $columnDefinition)
    {
        $this->columnDefinition = $columnDefinition;
    }

    public function write(RecordSetInterface $set, OutputInterface $output)
    {
        $table = new Table($output);
        $columns = $this->columnDefinition->getFormatColumns();
        $items = $this->convertRecordSetToArray($set, $columns);
        $table
            ->setHeaders(array_map('ucfirst', $columns))
            ->addRows($items)
        ;
        $table->addRow(new TableSeparator());
        $table->addRow([new TableCell('Total records ' . count($items), ['colspan' => count($columns)])]);
        $table->render();
    }

    /**
     * @param RecordSetInterface $set
     * @param array $columns
     * @return array
     */
    private function convertRecordSetToArray(RecordSetInterface $set, array $columns): array
    {
        if ($set instanceof ArrayConvertableInterface) {
            $array = $set->toArray();
        } else {
            $array = [];
            foreach ($set as $item) {
                $array[] = $item;
            }
        }
        $intersectColumns = array_flip($columns);

        return array_map(function ($record) use ($columns, $intersectColumns) {
            $data = is_array($record) ? $record : $record->toArray();
            return array_intersect_key(
                array_replace(array_flip($columns), $data),
                $intersectColumns
            );
        }, $array);
    }
}

<?php

namespace Oncesk\LogReader\Modification;

use Oncesk\LogReader\Record\RecordSet;
use Oncesk\LogReader\Record\RecordSetInterface;
use Symfony\Component\Console\Input\InputInterface;

class GroupModification implements ModificationInterface, ApplicableAwareInterface
{
    /**
     * @var InputInterface
     */
    private $input;

    /**
     * GroupProcessor constructor.
     * @param InputInterface $input
     */
    public function __construct(InputInterface $input)
    {
        $this->input = $input;
    }

    /**
     * @param InputInterface $input
     * @return bool
     */
    public function isApplicable(InputInterface $input): bool
    {
        return null !== $this->getGroupColumn();
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return 100;
    }

    /**
     * @param RecordSetInterface $set
     * @return RecordSetInterface
     */
    public function apply(RecordSetInterface $set): RecordSetInterface
    {
        $columns = $this->getGroupColumn();
        $cntColumn = $this->getGroupCountColumn();

        return new RecordSet(
            $this->groupBy($columns, $cntColumn, $set)
        );
    }

    /**
     * @param array $columns
     * @param string $cntColumn
     * @param $data
     * @return array
     */
    private function groupBy(array $columns, string $cntColumn, $data)
    {
        //  todo refactor, rewrite and split to small code pieces
        if (empty($columns)) {
            return $data;
        }
        $column = array_shift($columns);
        $countColumn = $column . '_' . $cntColumn;
        $data = $this->groupByColumn($column, $countColumn, $data);

        if (!empty($columns)) {
            return $this->groupNextColumns($columns, $cntColumn, $data);
        }

        array_walk($data, function (&$v) {
            unset($v['items']);
        });
        return array_values($data);
    }

    /**
     * @param string $column
     * @param string $countColumn
     * @param \IteratorAggregate|array $data
     * @return array
     */
    private function groupByColumn(string $column, string $countColumn, $data)
    {
        $result = [];
        foreach ($data as $record) {
            if (!isset($result[$record[$column]])) {
                $result[$record[$column]] = [
                    $column => $record[$column],
                    $countColumn => 1,
                    'items' => [$record]
                ];
            } else {
                $result[$record[$column]][$countColumn]++;
                $result[$record[$column]]['items'][] = $record;
            }
        }
        if ($uniqueColumn = $this->getGroupUniqueColumn()) {
            $result = $this->calculateUnique($uniqueColumn, $result);
        }
        return $result;
    }

    /**
     * @param array $columns
     * @param string $countColumn
     * @param array $data
     * @return array
     */
    private function groupNextColumns(array $columns, string $countColumn, $data)
    {
        foreach ($data as $k => $value) {
            $data[$k]['grouped'] = $this->groupBy($columns, $countColumn, $value['items']);
        }

        $result = [];
        foreach ($data as $groupKey => $group) {
            $firstGroup = array_shift($group['grouped']);
            $item = array_merge($group, $firstGroup);
            unset($item['items'], $item['grouped']);
            $result[] = $item;
            foreach ($group['grouped'] as $nestedGroupKey => $nestedGroup) {
                $itemNested = array_merge($group, $nestedGroup);
                unset($itemNested['items'], $itemNested['grouped']);
                $result[] = $itemNested;
            }
        }
        return $result;
    }

    private function calculateUnique(string $column, array $data): array
    {
        foreach ($data as &$record) {
            $uniqueTempContainer = [];
            foreach ($record['items'] as $item) {
                if (isset($item[$column])) {
                    isset($uniqueTempContainer[$item[$column]]) ? $uniqueTempContainer[$item[$column]]++ : $uniqueTempContainer[$item[$column]] = 1;
                }
            }
            $record[$column . '_unique'] = count($uniqueTempContainer);
        }
        return $data;
    }

    /**
     * @return string[]
     */
    private function getGroupColumn()
    {
        return (array) $this->input->getOption('group-by');
    }

    /**
     * @return string
     */
    private function getGroupCountColumn()
    {
        return $this->input->getOption('group-by-cnt-column');
    }

    /**
     * @return bool|string|string[]|null
     */
    private function getGroupUniqueColumn()
    {
        return $this->input->getOption('group-unique');
    }
}

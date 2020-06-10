<?php

namespace Oncesk\LogReader\Record;

/**
 * @codeCoverageIgnore
 */
class RecordSet implements RecordSetInterface
{
    /**
     * @var RecordInterface[]
     */
    private $items = [];

    /**
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * @param RecordInterface $record
     * @return RecordSetInterface
     */
    public function add($record): RecordSetInterface
    {
        $this->items[] = $record;

        return $this;
    }

    /**
     * @return RecordInterface[]
     */
    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * @return \Traversable
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }
}

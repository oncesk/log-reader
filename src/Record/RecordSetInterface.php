<?php

namespace Oncesk\LogReader\Record;

interface RecordSetInterface extends ArrayConvertableInterface, \IteratorAggregate
{
    /**
     * @param RecordInterface|array $record
     * @return RecordSetInterface
     */
    public function add($record): RecordSetInterface;

    /**
     * @return \Traversable|RecordInterface[]
     */
    public function getIterator(): \Traversable;
}

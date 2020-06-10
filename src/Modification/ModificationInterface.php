<?php

namespace Oncesk\LogReader\Modification;

use Oncesk\LogReader\Record\RecordSetInterface;

interface ModificationInterface
{
    /**
     * @return int
     */
    public function getPriority(): int;

    /**
     * @param RecordSetInterface $set
     * @return RecordSetInterface
     */
    public function apply(RecordSetInterface $set): RecordSetInterface;
}

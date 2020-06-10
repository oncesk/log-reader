<?php

namespace Oncesk\LogReader\Record;

interface RecordFactoryInterface
{
    /**
     * @param string $line
     * @return RecordInterface|array
     */
    public function createRecord(string $line): RecordInterface;
}

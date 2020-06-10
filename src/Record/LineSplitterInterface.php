<?php

namespace Oncesk\LogReader\Record;

interface LineSplitterInterface
{
    /**
     * @param string $line
     * @param string $delimiter
     * @return array
     */
    public function split(string $line, string $delimiter): array;
}

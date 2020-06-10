<?php

namespace Oncesk\LogReader\Record;

class LineSplitter implements LineSplitterInterface
{
    /**
     * @param string $line
     * @param string $delimiter
     * @return array
     */
    public function split(string $line, string $delimiter): array
    {
        return array_map('trim', explode($delimiter, $line));
    }
}

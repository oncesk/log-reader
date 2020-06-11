<?php

namespace Oncesk\LogReader\Record;

interface RecordInterface extends ArrayConvertableInterface
{
    /**
     * @param string $column
     * @return string|null
     */
    public function get(string $column): ?string;

    /**
     * @param string $column
     * @return bool
     */
    public function has(string $column): bool;

    /**
     * @return array
     */
    public function getValues(): array;
}

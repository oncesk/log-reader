<?php

namespace Oncesk\LogReader\Record;

interface ColumnDefinitionInterface
{
    /**
     * @return string[]
     */
    public function getColumns(): array;

    /**
     * @return string[]
     */
    public function getSchema(): array;

    /**
     * @return string
     */
    public function getFormat(): string;
}

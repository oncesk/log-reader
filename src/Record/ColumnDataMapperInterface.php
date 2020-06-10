<?php

namespace Oncesk\LogReader\Record;

interface ColumnDataMapperInterface
{
    /**
     * Returns associative array of columns to data
     *
     * @param ColumnDefinitionInterface $definition
     * @param array $data
     * @return array
     */
    public function map(ColumnDefinitionInterface $definition, array $data): array;
}

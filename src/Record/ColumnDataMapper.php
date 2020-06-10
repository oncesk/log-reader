<?php

namespace Oncesk\LogReader\Record;

class ColumnDataMapper implements ColumnDataMapperInterface
{
    /**
     * @param ColumnDefinitionInterface $definition
     * @param array $data
     * @return array
     */
    public function map(ColumnDefinitionInterface $definition, array $data): array
    {
        $assoc = [];
        foreach ($definition->getSchema() as $k => $column) {
            $assoc[$column] = $data[$k] ?? null;
        }
        $columns = $definition->getColumns();
        return array_intersect_key($assoc, array_combine($columns, $columns));
    }
}

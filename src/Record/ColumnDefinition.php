<?php

namespace Oncesk\LogReader\Record;

class ColumnDefinition implements ColumnDefinitionInterface
{
    /**
     * @var array
     */
    private $columns;

    /**
     * @var string
     */
    private $schema;

    /**
     * @var string|null
     */
    private $format;

    /**
     * @var array
     */
    private $formatColumns;

    /**
     * ColumnDefinition constructor.
     * @param string $schema
     * @param string|null $format
     */
    public function __construct(string $schema, ?string $format)
    {
        $this->schema = explode(' ', $schema);
        $this->format = $format;
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        if ($this->columns) {
            return $this->columns;
        }

        if (!$this->format || !preg_match_all('/\{\{\s([\w_-]+)\s\}\}/', $this->format, $m)) {
            return $this->getSchema();
        }

        return $this->columns = array_merge($this->getSchema(), $m[1]);
    }

    /**
     * @return array
     */
    public function getSchema(): array
    {
        return $this->schema;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    public function getFormatColumns(): array
    {
        if (null !== $this->formatColumns) {
            return $this->formatColumns;
        }

        if (!$this->format || !preg_match_all('/\{\{\s([\w_-]+)\s\}\}/', $this->format, $m)) {
            return $this->formatColumns = [];
        }

        return $this->formatColumns = $m[1];
    }
}

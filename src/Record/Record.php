<?php

namespace Oncesk\LogReader\Record;

/**
 * @codeCoverageIgnore
 */
class Record implements RecordInterface, \ArrayAccess
{
    /**
     * @var array
     */
    private $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param string $column
     * @return string|null
     */
    public function get(string $column): ?string
    {
        return $this->data[$column] ?? null;
    }

    /**
     * @param string $column
     * @return bool
     */
    public function has(string $column): bool
    {
        return isset($this->data[$column]);
    }

    /**
     * @return array
     */
    public function getValues(): array
    {
        return array_values($this->data);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }

    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        is_null($offset) ? $this->data[] = $value : $this->data[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }
}

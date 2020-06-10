<?php

namespace Oncesk\LogReader\SourceLog;

class FileResource implements FileResourceInterface
{
    /**
     * @var resource
     */
    private $resource;

    /**
     * @param resource $resource
     */
    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    /**
     * @return resource
     * @throws \RuntimeException
     */
    public function getResource()
    {
        if (!is_resource($this->resource)) {
            throw new \RuntimeException('Invalid cursor!');
        }

        return $this->resource;
    }
}

<?php

namespace Oncesk\LogReader\SourceLog;

class FileResourceFactory implements FileResourceFactoryInterface
{
    /**
     * @var string
     */
    private $stdin;

    /**
     * FileResourceFactory constructor.
     * @param string $stdin
     */
    public function __construct(string $stdin)
    {
        $this->stdin = $stdin;
    }

    /**
     * @param string $source
     * @return FileResourceInterface
     */
    public function createResource(string $source): FileResourceInterface
    {
        $this->validateSource($source);
        $resource = $this->open($source);

        return $this->createFileResource($resource);
    }

    /**
     * @param $resource
     * @return FileResource
     */
    private function createFileResource($resource)
    {
        return new FileResource($resource);
    }

    /**
     * @param string $source
     * @return false|resource
     */
    private function open(string $source)
    {
        $resource = fopen($source, 'r');

        if (!$resource) {
            throw new \RuntimeException('Unable to open resource ' . $resource);
        }

        return $resource;
    }

    /**
     * @param string $source
     * @throws \RuntimeException
     */
    private function validateSource(string $source)
    {
        if ($source !== $this->stdin && !is_readable($source)) {
            throw new \RuntimeException('The source ' . $source . ' is not exists or it is not readable');
        }
    }
}

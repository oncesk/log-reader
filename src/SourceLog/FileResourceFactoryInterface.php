<?php

namespace Oncesk\LogReader\SourceLog;

interface FileResourceFactoryInterface
{
    /**
     * @param string $source
     * @return FileResourceInterface
     * @throws \RuntimeException
     */
    public function createResource(string $source): FileResourceInterface;
}

<?php

namespace Oncesk\LogReader\SourceLog;

interface FileResourceInterface
{
    /**
     * @throws \RuntimeException
     * @return resource
     */
    public function getResource();
}

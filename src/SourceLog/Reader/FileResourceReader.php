<?php

namespace Oncesk\LogReader\SourceLog\Reader;

use Oncesk\LogReader\SourceLog\FileResourceInterface;
use Oncesk\LogReader\SourceLog\Filter\FilterInterface;
use Symfony\Component\Console\Input\InputInterface;

class FileResourceReader implements SourceLogReaderInterface
{
    /**
     * @var FileResourceInterface|resource
     */
    private $cursor;
    /**
     * @var FilterInterface
     */
    private $filter;
    /**
     * @var InputInterface
     */
    private $input;

    /**
     * FileCursorReader constructor.
     * @param FileResourceInterface $cursor
     * @param FilterInterface $filter
     * @param InputInterface $input
     */
    public function __construct(
        FileResourceInterface $cursor,
        FilterInterface $filter,
        InputInterface $input
    ) {
        $this->cursor = $cursor;
        $this->filter = $filter;
        $this->input = $input;
    }

    public function getIterator()
    {
        $resource = $this->cursor->getResource();
        $isFilterable = $this->filter->isApplicable($this->input);
        while (false !== $line = fgets($resource)) {
            if (!$isFilterable || ($isFilterable && $this->filter->isSuitable($this->input, $line))) {
                yield $line;
            }
        }
    }
}

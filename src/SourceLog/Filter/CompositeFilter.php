<?php

namespace Oncesk\LogReader\SourceLog\Filter;

use Symfony\Component\Console\Input\InputInterface;

class CompositeFilter implements FilterInterface
{
    /**
     * @var FilterInterface[]
     */
    private $filters = [];

    /**
     * @param FilterInterface $filter
     */
    public function add(FilterInterface $filter)
    {
        $this->filters[] = $filter;
    }

    /**
     * @param InputInterface $input
     * @return bool
     */
    public function isApplicable(InputInterface $input): bool
    {
        foreach ($this->filters as $filter) {
            if ($filter->isApplicable($input)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param InputInterface $input
     * @param string $line
     * @return bool
     */
    public function isSuitable(InputInterface $input, string $line): bool
    {
        foreach ($this->filters as $filter) {
            if ($filter->isApplicable($input) && !$filter->isSuitable($input, $line)) {
                return false;
            }
        }

        return true;
    }
}

<?php

namespace Oncesk\LogReader\SourceLog\Filter;

use Symfony\Component\Console\Input\InputInterface;

class SimpleSearchFilter implements FilterInterface
{
    /**
     * @param InputInterface $input
     * @return bool
     */
    public function isApplicable(InputInterface $input): bool
    {
        return null !== $this->getFilterString($input);
    }

    /**
     * @param InputInterface $input
     * @param string $line
     * @return bool
     */
    public function isSuitable(InputInterface $input, string $line): bool
    {
        return false !== strpos($line, $this->getFilterString($input));
    }

    /**
     * @param InputInterface $input
     * @return string|null
     */
    private function getFilterString(InputInterface $input): ?string
    {
        return $input->getOption('filter');
    }
}

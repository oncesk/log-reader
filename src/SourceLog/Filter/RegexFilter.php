<?php

namespace Oncesk\LogReader\SourceLog\Filter;

use Symfony\Component\Console\Input\InputInterface;

class RegexFilter implements FilterInterface
{
    /**
     * @param InputInterface $input
     * @return bool
     */
    public function isApplicable(InputInterface $input): bool
    {
        return null !== $this->getRegex($input);
    }

    /**
     * @param InputInterface $input
     * @param string $line
     * @return bool
     */
    public function isSuitable(InputInterface $input, string $line): bool
    {
        return preg_match(
            $this->getRegex($input),
            $line
        );
    }

    /**
     * @param InputInterface $input
     * @return string|null
     */
    private function getRegex(InputInterface $input): ?string
    {
        return $input->getOption('filter-regex');
    }
}

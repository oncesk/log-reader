<?php

namespace Oncesk\LogReader\SourceLog\Filter;

use Oncesk\LogReader\Modification\ApplicableAwareInterface;
use Symfony\Component\Console\Input\InputInterface;

interface FilterInterface extends ApplicableAwareInterface
{
    /**
     * @param InputInterface $input
     * @param string $line
     * @return bool
     */
    public function isSuitable(InputInterface $input, string $line): bool;
}

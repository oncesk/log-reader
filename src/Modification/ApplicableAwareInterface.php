<?php

namespace Oncesk\LogReader\Modification;

use Symfony\Component\Console\Input\InputInterface;

interface ApplicableAwareInterface
{
    /**
     * @param InputInterface $input
     * @return bool
     */
    public function isApplicable(InputInterface $input): bool;
}

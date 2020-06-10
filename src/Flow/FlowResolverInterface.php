<?php

namespace Oncesk\LogReader\Flow;

use Symfony\Component\Console\Input\InputInterface;

interface FlowResolverInterface
{
    /**
     * @param InputInterface $input
     * @return FlowInterface
     * @throws \RuntimeException
     */
    public function resolve(InputInterface $input): FlowInterface;
}

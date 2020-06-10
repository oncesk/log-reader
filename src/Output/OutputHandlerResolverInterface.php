<?php

namespace Oncesk\LogReader\Output;

use Symfony\Component\Console\Input\InputInterface;

interface OutputHandlerResolverInterface
{
    public function resolve(InputInterface $input);
}

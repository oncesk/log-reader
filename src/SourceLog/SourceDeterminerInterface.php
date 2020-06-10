<?php

namespace Oncesk\LogReader\SourceLog;

use Symfony\Component\Console\Input\InputInterface;

interface SourceDeterminerInterface
{
    /**
     * @param InputInterface $input
     * @return string
     * @throws \RuntimeException
     */
    public function determine(InputInterface $input): string;
}

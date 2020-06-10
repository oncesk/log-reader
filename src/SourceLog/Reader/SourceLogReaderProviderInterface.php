<?php

namespace Oncesk\LogReader\SourceLog\Reader;

use Symfony\Component\Console\Input\InputInterface;

interface SourceLogReaderProviderInterface
{
    /**
     * @param InputInterface $input
     * @return SourceLogReaderInterface
     */
    public function getSourceLogReader(InputInterface $input): SourceLogReaderInterface;
}

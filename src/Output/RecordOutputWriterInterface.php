<?php

namespace Oncesk\LogReader\Output;

use Symfony\Component\Console\Output\OutputInterface;

interface RecordOutputWriterInterface
{
    /**
     * @param array $record
     * @param OutputInterface $output
     */
    public function write(array $record, OutputInterface $output);
}

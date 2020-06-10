<?php

namespace Oncesk\LogReader\Output;

use Oncesk\LogReader\Record\RecordSetInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface OutputWriterInterface
{
    /**
     * @param RecordSetInterface $set
     * @param OutputInterface $output
     * @return mixed
     */
    public function write(RecordSetInterface $set, OutputInterface $output);
}

<?php

namespace Oncesk\LogReader\Record;

use Symfony\Component\Console\Input\InputInterface;

class ColumnDefinitionFactory
{
    /**
     * @param InputInterface $input
     * @return ColumnDefinitionInterface
     */
    public function create(InputInterface $input): ColumnDefinitionInterface
    {
        return new ColumnDefinition(
            $input->getOption('schema'),
            $input->getOption('output-format')
        );
    }
}

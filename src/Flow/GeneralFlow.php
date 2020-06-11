<?php

namespace Oncesk\LogReader\Flow;

use Oncesk\LogReader\Modification\ApplicableAwareInterface;
use Oncesk\LogReader\Modification\ModificationInterface;
use Oncesk\LogReader\Output\OutputWriterInterface;
use Oncesk\LogReader\Output\RecordOutputWriterInterface;
use Oncesk\LogReader\Record\RecordFactoryInterface;
use Oncesk\LogReader\Record\RecordInterface;
use Oncesk\LogReader\Record\RecordSet;
use Oncesk\LogReader\Record\RecordSetInterface;
use Oncesk\LogReader\SourceLog\Reader\SourceLogReaderProviderInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GeneralFlow implements FlowInterface
{
    /**
     * @var SourceLogReaderProviderInterface
     */
    private $sourceLogReaderProvider;

    /**
     * @var RecordFactoryInterface
     */
    private $recordFactory;

    /**
     * @var ModificationInterface
     */
    private $modification;

    /**
     * @var OutputWriterInterface
     */
    private $outputWriter;

    /**
     * @var RecordOutputWriterInterface
     */
    private $recordOutputWriter;

    /**
     * GeneralFlow constructor.
     * @param SourceLogReaderProviderInterface $sourceLogReaderProvider
     * @param RecordFactoryInterface $recordFactory
     * @param ModificationInterface $modification
     * @param OutputWriterInterface $outputWriter
     * @param RecordOutputWriterInterface $recordOutputWriter
     */
    public function __construct(
        SourceLogReaderProviderInterface $sourceLogReaderProvider,
        RecordFactoryInterface $recordFactory,
        ModificationInterface $modification,
        OutputWriterInterface $outputWriter,
        RecordOutputWriterInterface $recordOutputWriter
    ) {
        $this->sourceLogReaderProvider = $sourceLogReaderProvider;
        $this->recordFactory = $recordFactory;
        $this->modification = $modification;
        $this->outputWriter = $outputWriter;
        $this->recordOutputWriter = $recordOutputWriter;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function run(InputInterface $input, OutputInterface $output): int
    {
        $set = new RecordSet();
        $reader = $this->sourceLogReaderProvider->getSourceLogReader($input);
        foreach ($reader->getIterator() as $item) {
            $record = $this->recordFactory->createRecord($item);
            $set->add($record);
        }
        $set = $this->applyModification($input, $set, $this->modification);

        if ($input->getOption('table')) {
            $this->outputWriter->write($set, $output);
        } else {
            foreach ($set as $item) {
                $this->recordOutputWriter->write(
                    $item instanceof RecordInterface ? $item->toArray() : $item,
                    $output
                );
            }
        }
        return 0;
    }

    /**
     * @param InputInterface $input
     * @param RecordSetInterface $set
     * @param ModificationInterface $modification
     * @return RecordSetInterface
     */
    private function applyModification(
        InputInterface $input,
        RecordSetInterface $set,
        ModificationInterface $modification
    ): RecordSetInterface {
        if (!$modification instanceof ApplicableAwareInterface || $modification->isApplicable($input)) {
            return $modification->apply($set);
        }
        return $set;
    }
}

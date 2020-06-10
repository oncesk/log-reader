<?php

namespace Oncesk\LogReader\Flow;

use Oncesk\LogReader\Output\RecordOutputWriterInterface;
use Oncesk\LogReader\Record\ArrayConvertableInterface;
use Oncesk\LogReader\Record\RecordFactoryInterface;
use Oncesk\LogReader\SourceLog\Reader\SourceLogReaderProviderInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PipeFlow implements FlowInterface
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
     * @var RecordOutputWriterInterface
     */
    private $outputWriter;

    /**
     * PipeFlow constructor.
     * @param SourceLogReaderProviderInterface $sourceLogReaderProvider
     * @param RecordFactoryInterface $recordFactory
     * @param RecordOutputWriterInterface $outputWriter
     */
    public function __construct(
        SourceLogReaderProviderInterface $sourceLogReaderProvider,
        RecordFactoryInterface $recordFactory,
        RecordOutputWriterInterface $outputWriter
    ) {
        $this->sourceLogReaderProvider = $sourceLogReaderProvider;
        $this->recordFactory = $recordFactory;
        $this->outputWriter = $outputWriter;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function run(InputInterface $input, OutputInterface $output): int
    {
        $inputReader = $this->sourceLogReaderProvider->getSourceLogReader($input);
        foreach ($inputReader->getIterator() as $item) {
            $record = $this->recordFactory->createRecord($item);
            $this->outputWriter->write(
                $record instanceof ArrayConvertableInterface ? $record->toArray() : $record,
                $output
            );
        }
        return 0;
    }
}

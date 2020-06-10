<?php

namespace Oncesk\LogReader\SourceLog\Reader;

use Oncesk\LogReader\SourceLog\FileResourceFactoryInterface;
use Oncesk\LogReader\SourceLog\Filter\FilterInterface;
use Oncesk\LogReader\SourceLog\SourceDeterminerInterface;
use Symfony\Component\Console\Input\InputInterface;

class SourceLogReaderProvider implements SourceLogReaderProviderInterface
{
    /**
     * @var SourceDeterminerInterface
     */
    private $sourceDeterminer;

    /**
     * @var FileResourceFactoryInterface
     */
    private $resourceFactory;

    /**
     * @var InputInterface
     */
    private $input;

    /**
     * @var FilterInterface
     */
    private $filter;

    /**
     * @param SourceDeterminerInterface $sourceDeterminer
     * @param FileResourceFactoryInterface $resourceFactory
     * @param InputInterface $input
     * @param FilterInterface $filter
     */
    public function __construct(
        SourceDeterminerInterface $sourceDeterminer,
        FileResourceFactoryInterface $resourceFactory,
        InputInterface $input,
        FilterInterface $filter
    ) {
        $this->sourceDeterminer = $sourceDeterminer;
        $this->resourceFactory = $resourceFactory;
        $this->input = $input;
        $this->filter = $filter;
    }

    /**
     * @param InputInterface $input
     * @return SourceLogReaderInterface
     * @throws \RuntimeException
     */
    public function getSourceLogReader(InputInterface $input): SourceLogReaderInterface
    {
        $resource = $this->resourceFactory->createResource(
            $this->sourceDeterminer->determine($input)
        );

        return new FileResourceReader(
            $resource,
            $this->filter,
            $this->input
        );
    }
}

<?php

namespace Oncesk\LogReader\SourceLog;

use Symfony\Component\Console\Input\InputInterface;

class SourceDeterminer implements SourceDeterminerInterface
{
    /**
     * @var string
     */
    private $stdin;

    /**
     * @param string $stdin
     */
    public function __construct(string $stdin)
    {
        $this->stdin = $stdin;
    }

    /**
     * @param InputInterface $input
     * @return string
     */
    public function determine(InputInterface $input): string
    {
        if (false !== $input->getOption('stdin')) {
            return $this->stdin;
        }

        if ($file = $input->getArgument('file')) {
            return $file;
        }

        throw new \RuntimeException('Logs source is undefined');
    }
}

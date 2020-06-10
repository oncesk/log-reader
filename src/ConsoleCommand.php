<?php

namespace Oncesk\LogReader;

use Oncesk\LogReader\Flow\FlowResolverInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ConsoleCommand extends Command implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * ConsoleCommand constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
        parent::__construct('main');
    }

    protected function configure()
    {
        $this
            ->setDescription('This tool allows you to read logs in human readable format')
            ->setDefinition($this->getInputDefinition())
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->container->set(InputInterface::class, $input);
        return $this
            ->getFlowResolver()
            ->resolve($input)
            ->run($input, $output);
    }

    /**
     * @return FlowResolverInterface
     */
    private function getFlowResolver(): FlowResolverInterface
    {
        return $this->container->get(FlowResolverInterface::class);
    }

    /**
     * @param string $name
     * @return string|null
     */
    private function getProperty(string $name): ?string
    {
        return $this->container->getParameter($name);
    }

    /**
     * @return InputDefinition
     */
    private function getInputDefinition(): InputDefinition
    {
        return new InputDefinition([
            new InputArgument('file', InputArgument::OPTIONAL, 'Source logs file'),
            new InputOption('pipe', null, InputOption::VALUE_NONE, 'Work as a pipe'),
            new InputOption('table', 't', InputOption::VALUE_NONE, 'Show data in a table'),
            new InputOption(
                'output-format',
                'o',
                InputOption::VALUE_REQUIRED,
                'Format output log record',
                '{{ path }} {{ ip }}'
            ),
            new InputOption(
                'schema',
                's',
                InputOption::VALUE_REQUIRED,
                'Source logs column schema. User space as delimiter.',
                'path ip'
            ),
            new InputOption(
                'delimiter',
                'd',
                InputOption::VALUE_OPTIONAL,
                'Source line delimiter',
                $this->getProperty('delimiter')
            ),
            new InputOption('filter', null, InputOption::VALUE_REQUIRED, 'Filter logs according the filter string'),
            new InputOption('filter-regex', null, InputOption::VALUE_REQUIRED, 'Filter logs according a regex'),
            new InputOption('stdin', 'i', InputOption::VALUE_NONE, 'Read logs from stdin'),
            new InputOption('group-by', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Group items by a column.'),
            new InputOption('group-by-cnt-column', null, InputOption::VALUE_REQUIRED, 'Set column name for number of grouped items', 'cnt'),
            new InputOption('sort-key', 'sk', InputOption::VALUE_OPTIONAL, 'Set a column for sorting items.', 'path'),
            new InputOption('sort-order', 'so', InputOption::VALUE_OPTIONAL, 'Sort order ascending[asc] or descending[desc].', 'asc')
        ]);
    }
}

<?php

namespace Oncesk\LogReader\Flow;

use Symfony\Component\Console\Input\InputInterface;

class Resolver implements FlowResolverInterface
{
    /**
     * @var FlowInterface
     */
    private $pipeFlow;

    /**
     * @var FlowInterface
     */
    private $generalFlow;

    /**
     * @param FlowInterface $flow
     */
    public function setPipeFlow(FlowInterface $flow)
    {
        $this->pipeFlow = $flow;
    }

    /**
     * @param FlowInterface $flow
     */
    public function setGeneralFlow(FlowInterface $flow)
    {
        $this->generalFlow = $flow;
    }

    /**
     * @param InputInterface $input
     * @return FlowInterface
     */
    public function resolve(InputInterface $input): FlowInterface
    {
        return false !== $input->getOption('pipe') ? $this->pipeFlow : $this->generalFlow;
    }
}

<?php

namespace Oncesk\LogReader\Modification;

use Oncesk\LogReader\Record\RecordSetInterface;
use Symfony\Component\Console\Input\InputInterface;

class Modification implements ModificationInterface
{
    /**
     * @var ModificationInterface[]
     */
    private $modifications = [];

    /**
     * @var InputInterface
     */
    private $input;

    /**
     * Modification constructor.
     * @param InputInterface $input
     */
    public function __construct(InputInterface $input)
    {
        $this->input = $input;
    }

    /**
     * @param ModificationInterface $modification
     * @return $this
     */
    public function add(ModificationInterface $modification)
    {
        $this->modifications[] = $modification;
        return $this;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return 0;
    }

    /**
     * @param RecordSetInterface $set
     * @return RecordSetInterface
     */
    public function apply(RecordSetInterface $set): RecordSetInterface
    {
        usort($this->modifications, [$this, 'sorter']);
        foreach ($this->modifications as $modification) {
            if ($this->shouldApplyModification($modification)) {
                $set = $modification->apply($set);
            }
        }

        return $set;
    }

    /**
     * @param ModificationInterface $modification
     * @return bool
     */
    private function shouldApplyModification(ModificationInterface $modification): bool
    {
        return !$modification instanceof ApplicableAwareInterface || $modification->isApplicable($this->input);
    }

    /**
     * @param ModificationInterface $a
     * @param ModificationInterface $b
     * @return int
     */
    private function sorter(ModificationInterface $a, ModificationInterface $b): int
    {
        return $b->getPriority() <=> $a->getPriority();
    }
}

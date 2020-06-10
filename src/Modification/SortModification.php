<?php

namespace Oncesk\LogReader\Modification;

use Oncesk\LogReader\Record\RecordSet;
use Oncesk\LogReader\Record\RecordSetInterface;
use Symfony\Component\Console\Input\InputInterface;

class SortModification implements ModificationInterface, ApplicableAwareInterface
{
    /**
     * @var InputInterface
     */
    private $input;

    /**
     * SortModification constructor.
     * @param InputInterface $input
     */
    public function __construct(InputInterface $input)
    {
        $this->input = $input;
    }

    /**
     * @param InputInterface $input
     * @return bool
     */
    public function isApplicable(InputInterface $input): bool
    {
        return (bool) $this->getSortField();
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return 1;
    }

    /**
     * @param RecordSetInterface $set
     * @return RecordSetInterface
     */
    public function apply(RecordSetInterface $set): RecordSetInterface
    {
        $items = $set->toArray();
        $sortField = $this->getSortField();
        usort($items, function ($a, $b) use ($sortField) {
            return $a[$sortField] <=> $b[$sortField];
        });
        if ($this->isSortOrderDesc($this->getSortOrder())) {
            $items = array_reverse($items);
        }
        //  todo refactor, rewrite with different way
        return new RecordSet($items);
    }

    /**
     * @return string
     */
    private function getSortField(): ?string
    {
        return $this->input->getOption('sort-key');
    }

    /**
     * @return string
     */
    private function getSortOrder(): ?string
    {
        return $this->input->getOption('sort-order');
    }

    /**
     * @param string|null $order
     * @return bool
     */
    private function isSortOrderDesc(?string $order): bool
    {
        return 'desc' === $order;
    }
}

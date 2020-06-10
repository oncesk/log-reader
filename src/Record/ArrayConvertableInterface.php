<?php

namespace Oncesk\LogReader\Record;

interface ArrayConvertableInterface
{
    /**
     * @return array
     */
    public function toArray(): array;
}

<?php

namespace CBH\DataBaseIterator\Factory;

use CBH\DataBaseIterator\AggregatorInterface;
use CBH\DataBaseIterator\Range;

class RangeFactory
{
    /**
     * @param AggregatorInterface $aggregator
     * @param int                 $step
     *
     * @throws \CBH\DataBaseIterator\Exception\InvalidArgument
     *
     * @return Range
     */
    public function fromAggregator(AggregatorInterface $aggregator, $step = 500)
    {
        $info = $aggregator->getInfo();

        return new Range($info->getMin(), $info->getMax(), $step);
    }
}

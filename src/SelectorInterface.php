<?php

namespace CBH\DataBaseIterator;

use CBH\DataBaseIterator\ValueObject\AggregationInfo;

interface SelectorInterface
{
    /**
     * @param RangeInterface $range
     *
     * @return \Generator - loaded data
     */
    public function load(RangeInterface $range);

    /**
     * Aggregate info with criteria
     *
     * @throws \CBH\DataBaseIterator\Exception\InvalidArgument
     *
     * @return AggregationInfo
     */
    public function aggregate();
}

<?php

namespace CBH\DataBaseIterator;

use CBH\DataBaseIterator\ValueObject\AggregationInfo;

interface AggregatorInterface
{
    /**
     * Get aggregation info
     *
     * @throws \CBH\DataBaseIterator\Exception\InvalidArgument
     *
     * @return AggregationInfo
     */
    public function getInfo();
}

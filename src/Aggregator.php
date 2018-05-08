<?php

namespace CBH\DataBaseIterator;

use CBH\DataBaseIterator\ValueObject\AggregationInfo;

class Aggregator implements AggregatorInterface
{
    /** @var SelectorInterface */
    private $selector;

    /** @var AggregationInfo */
    private $info;

    /**
     * Aggregator constructor.
     *
     * @param SelectorInterface $selector
     */
    public function __construct(SelectorInterface $selector)
    {
        $this->selector = $selector;
    }

    /**
     * Get aggregation info
     *
     * @throws \CBH\DataBaseIterator\Exception\InvalidArgument
     *
     * @return AggregationInfo
     */
    public function getInfo()
    {
        if (null === $this->info) {
            $this->info = $this->selector->aggregate();
        }

        return $this->info;
    }
}

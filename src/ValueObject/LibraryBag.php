<?php

namespace CBH\DataBaseIterator\ValueObject;

use CBH\DataBaseIterator\AggregatorInterface;
use CBH\DataBaseIterator\Iterator;

class LibraryBag
{
    /** @var AggregatorInterface */
    private $aggregator;
    /** @var Iterator */
    private $iterator;

    /**
     * LibraryBag constructor.
     *
     * @param AggregatorInterface $aggregator
     * @param Iterator            $iterator
     */
    public function __construct(
        AggregatorInterface $aggregator,
        Iterator $iterator
    ) {
        $this->aggregator = $aggregator;
        $this->iterator = $iterator;
    }

    /**
     * @return AggregatorInterface
     */
    public function getAggregator()
    {
        return $this->aggregator;
    }

    /**
     * @return Iterator
     */
    public function getIterator()
    {
        return $this->iterator;
    }
}

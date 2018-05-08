<?php

namespace CBH\DataBaseIterator\Builder;

use CBH\DataBaseIterator\Aggregator;
use CBH\DataBaseIterator\AggregatorInterface;
use CBH\DataBaseIterator\Exception;
use CBH\DataBaseIterator\SelectorInterface;

class AggregatorBuilder
{
    /** @var SelectorInterface */
    private $selector;

    /**
     * @param SelectorInterface $selector
     *
     * @return AggregatorBuilder
     */
    public function setSelector($selector)
    {
        $this->selector = $selector;

        return $this;
    }

    /**
     * @throws \CBH\DataBaseIterator\Exception\BuilderNotFullFilled
     *
     * @return AggregatorInterface
     */
    public function getAggregator()
    {
        if ($this->selector === null) {
            throw new Exception\BuilderNotFullFilled;
        }

        return new Aggregator($this->selector);
    }
}

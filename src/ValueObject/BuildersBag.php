<?php

namespace CBH\DataBaseIterator\ValueObject;

use CBH\DataBaseIterator\Builder\AggregatorBuilder;
use CBH\DataBaseIterator\Builder\IteratorBuilder;
use CBH\DataBaseIterator\Builder\SelectorBuilder;

class BuildersBag
{
    /** @var AggregatorBuilder */
    private $aggregatorBuilder;
    /** @var IteratorBuilder */
    private $iteratorBuilder;
    /** @var SelectorBuilder */
    private $selectorBuilder;

    /**
     * BuildersBag constructor.
     *
     * @param AggregatorBuilder $aggregatorBuilder
     * @param IteratorBuilder   $iteratorBuilder
     * @param SelectorBuilder   $selectorBuilder
     */
    public function __construct(
        AggregatorBuilder $aggregatorBuilder,
        IteratorBuilder $iteratorBuilder,
        SelectorBuilder $selectorBuilder
    ) {
        $this->aggregatorBuilder = $aggregatorBuilder;
        $this->iteratorBuilder = $iteratorBuilder;
        $this->selectorBuilder = $selectorBuilder;
    }


    /**
     * @return AggregatorBuilder
     */
    public function getAggregatorBuilder()
    {
        return $this->aggregatorBuilder;
    }

    /**
     * @return IteratorBuilder
     */
    public function getIteratorBuilder()
    {
        return $this->iteratorBuilder;
    }

    /**
     * @return SelectorBuilder
     */
    public function getSelectorBuilder()
    {
        return $this->selectorBuilder;
    }
}

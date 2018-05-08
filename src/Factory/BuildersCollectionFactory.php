<?php

namespace CBH\DataBaseIterator\Factory;

use CBH\DataBaseIterator\Builder\AggregatorBuilder;
use CBH\DataBaseIterator\Builder\IteratorBuilder;
use CBH\DataBaseIterator\Builder\SelectorBuilder;
use CBH\DataBaseIterator\Collection\BuildersCollection;
use CBH\DataBaseIterator\ValueObject\BuildersBag;

class BuildersCollectionFactory
{
    /**
     * @return BuildersCollection
     */
    public function make()
    {
        $bag = new BuildersBag(
            new AggregatorBuilder,
            new IteratorBuilder,
            new SelectorBuilder
        );

        return new BuildersCollection($bag);
    }
}

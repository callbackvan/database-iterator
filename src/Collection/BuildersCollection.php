<?php

namespace CBH\DataBaseIterator\Collection;

use CBH\DataBaseIterator\RangeInterface;
use CBH\DataBaseIterator\SelectorInterface;
use CBH\DataBaseIterator\ValueObject\BuildersBag;

class BuildersCollection
{
    /** @var BuildersBag */
    private $collection;

    /**
     * BuildersCollection constructor.
     *
     * @param BuildersBag $collection
     */
    public function __construct(BuildersBag $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return BuildersBag
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @param \Zend\Db\Sql\Sql $sql
     *
     * @return BuildersCollection
     */
    public function setSql($sql)
    {
        $this->collection->getSelectorBuilder()->setSql($sql);

        return $this;
    }

    /**
     * @param string $table
     *
     * @return BuildersCollection
     */
    public function setTable($table)
    {
        $this->collection->getSelectorBuilder()->setTable($table);

        return $this;
    }

    /**
     * @param array|\Closure|string|\Zend\Db\Sql\Predicate\PredicateInterface|\Zend\Db\Sql\Where $criteria
     *
     * @return BuildersCollection
     */
    public function setCriteria($criteria)
    {
        $this->collection->getSelectorBuilder()->setCriteria($criteria);

        return $this;
    }

    /**
     * @param string $iterateOver
     *
     * @return BuildersCollection
     */
    public function setIterateOver($iterateOver)
    {
        $this->collection->getSelectorBuilder()->setIterateOver($iterateOver);

        return $this;
    }

    /**
     * @param SelectorInterface $selector
     *
     * @return BuildersCollection
     */
    public function setSelector($selector)
    {
        $this->collection->getAggregatorBuilder()->setSelector($selector);
        $this->collection->getIteratorBuilder()->setSelector($selector);

        return $this;
    }

    /**
     * @param RangeInterface $range
     *
     * @return BuildersCollection
     */
    public function setRange($range)
    {
        $this->collection->getIteratorBuilder()->setRange($range);

        return $this;
    }

    /**
     * @param array $fields
     *
     * @return BuildersCollection
     */
    public function setFields($fields)
    {
        $this->collection->getSelectorBuilder()->setFields($fields);

        return $this;
    }
}

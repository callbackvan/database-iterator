<?php

namespace CBH\DataBaseIterator\Factory;

use CBH\DataBaseIterator\ValueObject\LibraryBag;

class LibraryFactory
{
    /** @var \Zend\Db\Sql\Sql */
    private $sql;

    /** @var BuildersCollectionFactory */
    private $buildersFactory;

    /** @var RangeFactory */
    private $rangeFactory;

    /**
     * LibraryFactory constructor.
     *
     * @param \Zend\Db\Sql\Sql          $sql
     * @param BuildersCollectionFactory $buildersFactory
     * @param RangeFactory              $rangeFactory
     */
    public function __construct(
        \Zend\Db\Sql\Sql $sql,
        BuildersCollectionFactory $buildersFactory,
        RangeFactory $rangeFactory
    ) {
        $this->sql = $sql;
        $this->buildersFactory = $buildersFactory;
        $this->rangeFactory = $rangeFactory;
    }

    /**
     * @param string $table
     * @param array  $params
     *
     * @throws \CBH\DataBaseIterator\Exception\BuilderNotFullFilled
     * @throws \CBH\DataBaseIterator\Exception\InvalidArgument
     *
     * @return LibraryBag
     */
    public function makeLibrary($table, array $params)
    {
        $builders = $this->buildersFactory
            ->make()
            ->setSql($this->sql)
            ->setTable($table);

        if (isset($params['criteria'])) {
            $builders->setCriteria($params['criteria']);
        }

        if (isset($params['iterateOver'])) {
            $builders->setIterateOver($params['iterateOver']);
        }

        if (isset($params['fields'])) {
            $builders->setFields($params['fields']);
        }

        $step = isset($params['step']) ? $params['step'] : 500;

        $buildersBag = $builders->getCollection();

        $selector = $buildersBag
            ->getSelectorBuilder()
            ->getSelector();

        $builders->setSelector($selector);

        $aggregator = $buildersBag
            ->getAggregatorBuilder()
            ->getAggregator();

        $range = $this->rangeFactory->fromAggregator($aggregator, $step);
        $builders->setRange($range);

        $iterator = $buildersBag
            ->getIteratorBuilder()
            ->getIterator();

        return new LibraryBag($aggregator, $iterator);
    }
}

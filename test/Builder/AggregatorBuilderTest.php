<?php

namespace CBH\DataBaseIterator\Builder;

use CBH\DataBaseIterator\AggregatorInterface;
use CBH\DataBaseIterator\SelectorInterface;

class AggregatorBuilderTest extends \PHPUnit_Framework_TestCase
{
    /** @var AggregatorBuilder */
    private $builder;

    /**
     * @covers \CBH\DataBaseIterator\Builder\AggregatorBuilder::setSelector
     * @covers \CBH\DataBaseIterator\Builder\AggregatorBuilder::getAggregator
     *
     * @throws \CBH\DataBaseIterator\Exception\BuilderNotFullFilled
     */
    public function testGetAggregator()
    {
        $this->builder
            ->setSelector(
                $this->createMock(SelectorInterface::class)
            );
        $this->assertInstanceOf(
            AggregatorInterface::class,
            $this->builder->getAggregator()
        );
    }

    /**
     * @covers \CBH\DataBaseIterator\Builder\AggregatorBuilder::getAggregator
     *
     * @expectedException \CBH\DataBaseIterator\Exception\BuilderNotFullFilled
     */
    public function testGetAggregatorThrowsRuntime()
    {
        $this->builder->getAggregator();
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->builder = new AggregatorBuilder;
    }
}

<?php

namespace CBH\DataBaseIterator\Builder;

use CBH\DataBaseIterator\Iterator;
use CBH\DataBaseIterator\RangeInterface;
use CBH\DataBaseIterator\SelectorInterface;

class IteratorBuilderTest extends \PHPUnit_Framework_TestCase
{
    /** @var IteratorBuilder */
    private $builder;

    /**
     * @covers \CBH\DataBaseIterator\Builder\IteratorBuilder::setSelector
     * @covers \CBH\DataBaseIterator\Builder\IteratorBuilder::setRange
     * @covers \CBH\DataBaseIterator\Builder\IteratorBuilder::getIterator
     * @throws \CBH\DataBaseIterator\Exception\BuilderNotFullFilled
     */
    public function testGetIterator()
    {
        $this->builder
            ->setSelector(
                $this->createMock(SelectorInterface::class)
            );
        $this->builder
            ->setRange(
                $this->createMock(RangeInterface::class)
            );

        $this->assertInstanceOf(
            Iterator::class,
            $this->builder->getIterator()
        );
    }

    /**
     * @covers \CBH\DataBaseIterator\Builder\IteratorBuilder::getIterator
     *
     * @expectedException \CBH\DataBaseIterator\Exception\BuilderNotFullFilled
     */
    public function testGetIteratorThrowsRuntime()
    {
        $this->builder->getIterator();
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->builder = new IteratorBuilder;
    }
}

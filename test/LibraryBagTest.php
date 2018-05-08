<?php

namespace CBH\DataBaseIterator\ValueObject;

use CBH\DataBaseIterator\AggregatorInterface;
use CBH\DataBaseIterator\Iterator;

class LibraryBagTest extends \PHPUnit_Framework_TestCase
{
    /** @var LibraryBag */
    private $bag;
    /** @var AggregatorInterface */
    private $aggregator;
    /** @var Iterator */
    private $iterator;

    /**
     * @covers \CBH\DataBaseIterator\ValueObject\LibraryBag::__construct
     * @covers \CBH\DataBaseIterator\ValueObject\LibraryBag::getAggregator
     */
    public function testGetAggregator()
    {
        $this->assertSame(
            $this->aggregator,
            $this->bag->getAggregator()
        );
    }

    /**
     * @covers \CBH\DataBaseIterator\ValueObject\LibraryBag::__construct
     * @covers \CBH\DataBaseIterator\ValueObject\LibraryBag::getIterator
     */
    public function testGetSelector()
    {
        $this->assertSame(
            $this->iterator,
            $this->bag->getIterator()
        );
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->bag = new LibraryBag(
            $this->aggregator = $this->createMock(AggregatorInterface::class),
            $this->iterator = $this->createMock(Iterator::class)
        );
    }
}

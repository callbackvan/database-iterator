<?php

namespace CBH\DataBaseIterator\ValueObject;


use CBH\DataBaseIterator\Builder\AggregatorBuilder;
use CBH\DataBaseIterator\Builder\IteratorBuilder;
use CBH\DataBaseIterator\Builder\SelectorBuilder;

class BuildersBagTest extends \PHPUnit_Framework_TestCase
{
    /** @var BuildersBag */
    private $bag;
    /** @var AggregatorBuilder */
    private $aggregatorBuilder;
    /** @var IteratorBuilder */
    private $iteratorBuilder;
    /** @var SelectorBuilder */
    private $selectorBuilder;

    /**
     * @covers \CBH\DataBaseIterator\ValueObject\BuildersBag::__construct
     * @covers \CBH\DataBaseIterator\ValueObject\BuildersBag::getAggregatorBuilder
     */
    public function testGetIteratorBuilder()
    {
        $this->assertSame(
            $this->aggregatorBuilder,
            $this->bag->getAggregatorBuilder()
        );
    }

    /**
     * @covers \CBH\DataBaseIterator\ValueObject\BuildersBag::__construct
     * @covers \CBH\DataBaseIterator\ValueObject\BuildersBag::getIteratorBuilder
     */
    public function testGetSelectorBuilder()
    {
        $this->assertSame(
            $this->iteratorBuilder,
            $this->bag->getIteratorBuilder()
        );
    }

    /**
     * @covers \CBH\DataBaseIterator\ValueObject\BuildersBag::__construct
     * @covers \CBH\DataBaseIterator\ValueObject\BuildersBag::getSelectorBuilder
     */
    public function testGetAggregatorBuilder()
    {
        $this->assertSame(
            $this->selectorBuilder,
            $this->bag->getSelectorBuilder()
        );
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->bag = new BuildersBag(
            $this->aggregatorBuilder = $this->createMock(
                AggregatorBuilder::class
            ),
            $this->iteratorBuilder = $this->createMock(
                IteratorBuilder::class
            ),
            $this->selectorBuilder = $this->createMock(
                SelectorBuilder::class
            )
        );
    }


}

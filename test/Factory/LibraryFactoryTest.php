<?php

namespace CBH\DataBaseIterator\Factory;

use CBH\DataBaseIterator\AggregatorInterface;
use CBH\DataBaseIterator\Builder\AggregatorBuilder;
use CBH\DataBaseIterator\Builder\IteratorBuilder;
use CBH\DataBaseIterator\Builder\SelectorBuilder;
use CBH\DataBaseIterator\Collection\BuildersCollection;
use CBH\DataBaseIterator\Iterator;
use CBH\DataBaseIterator\RangeInterface;
use CBH\DataBaseIterator\SelectorInterface;
use CBH\DataBaseIterator\ValueObject\BuildersBag;

class LibraryFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var LibraryFactory */
    private $factory;

    /** @var \Zend\Db\Sql\Sql */
    private $sql;
    /** @var BuildersCollectionFactory */
    private $buildersFactory;
    /** @var RangeFactory */
    private $rangeFactory;

    /**
     * @covers \CBH\DataBaseIterator\Factory\LibraryFactory::__construct
     * @covers \CBH\DataBaseIterator\Factory\LibraryFactory::makeLibrary
     *
     * @throws \CBH\DataBaseIterator\Exception\BuilderNotFullFilled
     * @throws \CBH\DataBaseIterator\Exception\InvalidArgument
     */
    public function testMakeLibrary()
    {
        $this->buildersFactory
            ->expects($this->once())
            ->method('make')
            ->willReturn(
                $collection = $this->createMock(
                    BuildersCollection::class
                )
            );

        $collection
            ->expects($this->once())
            ->method('setSql')
            ->with($this->sql)
            ->willReturnSelf();
        $collection
            ->expects($this->once())
            ->method('setTable')
            ->with($table = 'table')
            ->willReturnSelf();
        $collection
            ->expects($this->once())
            ->method('setCriteria')
            ->with($criteria = 'criteria')
            ->willReturnSelf();
        $collection
            ->expects($this->once())
            ->method('setIterateOver')
            ->with($iterateOver = 'field')
            ->willReturnSelf();
        $collection
            ->expects($this->once())
            ->method('setSelector')
            ->with($selector = $this->createMock(SelectorInterface::class))
            ->willReturnSelf();
        $collection
            ->expects($this->once())
            ->method('setRange')
            ->with($range = $this->createMock(RangeInterface::class))
            ->willReturnSelf();
        $collection
            ->expects($this->once())
            ->method('setFields')
            ->with($fields = ['field 1', 'field 2'])
            ->willReturnSelf();
        $collection
            ->expects($this->once())
            ->method('getCollection')
            ->willReturn(
                $bag = $this->createMock(
                    BuildersBag::class
                )
            );

        $bag
            ->expects($this->once())
            ->method('getIteratorBuilder')
            ->willReturn(
                $iteratorBuilder = $this->createMock(
                    IteratorBuilder::class
                )
            );
        $bag
            ->expects($this->once())
            ->method('getAggregatorBuilder')
            ->willReturn(
                $aggregatorBuilder = $this->createMock(
                    AggregatorBuilder::class
                )
            );
        $bag
            ->expects($this->once())
            ->method('getSelectorBuilder')
            ->willReturn(
                $selectorBuilder = $this->createMock(
                    SelectorBuilder::class
                )
            );

        $iteratorBuilder
            ->expects($this->once())
            ->method('getIterator')
            ->willReturn(
                $iterator = $this->createMock(
                    Iterator::class
                )
            );
        $aggregatorBuilder
            ->expects($this->once())
            ->method('getAggregator')
            ->willReturn(
                $aggregator = $this->createMock(
                    AggregatorInterface::class
                )
            );
        $selectorBuilder
            ->expects($this->once())
            ->method('getSelector')
            ->willReturn(
                $selector = $this->createMock(
                    SelectorInterface::class
                )
            );

        $this->rangeFactory
            ->expects($this->once())
            ->method('fromAggregator')
            ->with($aggregator, $step = 234)
            ->willReturn($range);

        $params = [
            'criteria'    => $criteria,
            'iterateOver' => $iterateOver,
            'fields'      => $fields,
            'step'        => $step,
        ];

        $library = $this->factory->makeLibrary($table, $params);
        $this->assertSame($aggregator, $library->getAggregator());
        $this->assertSame($iterator, $library->getIterator());
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->factory = new LibraryFactory(
            $this->sql = $this->createMock(
                \Zend\Db\Sql\Sql ::class
            ),
            $this->buildersFactory = $this->createMock(
                BuildersCollectionFactory ::class
            ),
            $this->rangeFactory = $this->createMock(
                RangeFactory ::class
            )
        );
    }
}

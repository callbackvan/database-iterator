<?php

namespace CBH\DataBaseIterator\Collection;


use CBH\DataBaseIterator\Builder\AggregatorBuilder;
use CBH\DataBaseIterator\Builder\IteratorBuilder;
use CBH\DataBaseIterator\Builder\SelectorBuilder;
use CBH\DataBaseIterator\RangeInterface;
use CBH\DataBaseIterator\SelectorInterface;
use CBH\DataBaseIterator\ValueObject\BuildersBag;
use Zend\Db\Sql\Sql;

class BuildersCollectionTest extends \PHPUnit_Framework_TestCase
{
    /** @var BuildersCollection */
    private $collection;
    /** @var BuildersBag */
    private $bag;

    /** @var SelectorBuilder */
    private $selectorBuilder;
    /** @var AggregatorBuilder */
    private $aggregatorBuilder;
    /** @var IteratorBuilder */
    private $iteratorBuilder;

    /**
     * @covers \CBH\DataBaseIterator\Collection\BuildersCollection::__construct
     * @covers \CBH\DataBaseIterator\Collection\BuildersCollection::getCollection
     */
    public function testGetCollection()
    {
        $this->assertSame($this->bag, $this->collection->getCollection());
    }

    /**
     * @covers \CBH\DataBaseIterator\Collection\BuildersCollection::__construct
     * @covers \CBH\DataBaseIterator\Collection\BuildersCollection::setSql
     */
    public function testSetSql()
    {
        $this->prepareBuildersForSet(
            'setSql',
            $value = $this->createMock(Sql::class)
        );
        $this->assertSame(
            $this->collection,
            $this->collection->setSql($value)
        );
    }

    /**
     * @covers \CBH\DataBaseIterator\Collection\BuildersCollection::__construct
     * @covers \CBH\DataBaseIterator\Collection\BuildersCollection::setFields
     */
    public function testSetFields()
    {
        $this->prepareBuildersForSet(
            'setFields',
            $value = ['field 1', 'field 2']
        );
        $this->assertSame(
            $this->collection,
            $this->collection->setFields($value)
        );
    }

    /**
     * @covers \CBH\DataBaseIterator\Collection\BuildersCollection::__construct
     * @covers \CBH\DataBaseIterator\Collection\BuildersCollection::setTable
     */
    public function testSetTable()
    {
        $this->prepareBuildersForSet(
            'setTable',
            $value = 'my table'
        );
        $this->assertSame(
            $this->collection,
            $this->collection->setTable($value)
        );
    }

    /**
     * @covers \CBH\DataBaseIterator\Collection\BuildersCollection::__construct
     * @covers \CBH\DataBaseIterator\Collection\BuildersCollection::setCriteria
     */
    public function testSetCriteria()
    {
        $this->prepareBuildersForSet(
            'setCriteria',
            $value = 'foo = bar'
        );
        $this->assertSame(
            $this->collection,
            $this->collection->setCriteria($value)
        );
    }

    /**
     * @covers \CBH\DataBaseIterator\Collection\BuildersCollection::__construct
     * @covers \CBH\DataBaseIterator\Collection\BuildersCollection::setSelector
     */
    public function testSetSelector()
    {
        $this->prepareBuildersForSet(
            'setSelector',
            $value = $this->createMock(SelectorInterface::class)
        );
        $this->assertSame(
            $this->collection,
            $this->collection->setSelector($value)
        );
    }

    /**
     * @covers \CBH\DataBaseIterator\Collection\BuildersCollection::__construct
     * @covers \CBH\DataBaseIterator\Collection\BuildersCollection::setRange
     */
    public function testSetRange()
    {
        $this->prepareBuildersForSet(
            'setRange',
            $value = $this->createMock(RangeInterface::class)
        );
        $this->assertSame(
            $this->collection,
            $this->collection->setRange($value)
        );
    }

    /**
     * @covers \CBH\DataBaseIterator\Collection\BuildersCollection::__construct
     * @covers \CBH\DataBaseIterator\Collection\BuildersCollection::setIterateOver
     */
    public function testSetIterateOver()
    {
        $this->prepareBuildersForSet(
            'setIterateOver',
            $value = 'field 67'
        );
        $this->assertSame(
            $this->collection,
            $this->collection->setIterateOver($value)
        );
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->collection = new BuildersCollection(
            $this->bag = $this->createMock(BuildersBag::class)
        );

        $this->bag
            ->expects($this->any())
            ->method('getSelectorBuilder')
            ->willReturn(
                $this->selectorBuilder = $this->createMock(
                    SelectorBuilder::class
                )
            );

        $this->bag
            ->expects($this->any())
            ->method('getAggregatorBuilder')
            ->willReturn(
                $this->aggregatorBuilder = $this->createMock(
                    AggregatorBuilder::class
                )
            );

        $this->bag
            ->expects($this->any())
            ->method('getIteratorBuilder')
            ->willReturn(
                $this->iteratorBuilder = $this->createMock(
                    IteratorBuilder::class
                )
            );
    }

    private function prepareBuildersForSet($method, $value)
    {
        $builders = [
            $this->selectorBuilder,
            $this->aggregatorBuilder,
            $this->iteratorBuilder,
        ];
        /** @var \PHPUnit_Framework_MockObject_MockObject $builder */
        foreach ($builders as $builder) {
            if (method_exists($builder, $method)) {
                $builder
                    ->expects($this->once())
                    ->method($method)
                    ->with($value);
            }
        }
    }
}

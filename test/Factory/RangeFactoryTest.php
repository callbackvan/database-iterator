<?php

namespace CBH\DataBaseIterator\Factory;


use CBH\DataBaseIterator\AggregatorInterface;
use CBH\DataBaseIterator\ValueObject\AggregationInfo;

class RangeFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var RangeFactory */
    private $factory;

    /**
     * @covers \CBH\DataBaseIterator\Factory\RangeFactory::fromAggregator
     *
     * @throws \CBH\DataBaseIterator\Exception\InvalidArgument
     */
    public function testFromAggregator()
    {
        $aggregator = $this->createMock(
            AggregatorInterface::class
        );

        $aggregator
            ->expects($this->once())
            ->method('getInfo')
            ->willReturn(
                $info = $this->createMock(
                    AggregationInfo::class
                )
            );

        $info
            ->expects($this->once())
            ->method('getMin')
            ->willReturn($min = 123);

        $info
            ->expects($this->once())
            ->method('getMax')
            ->willReturn($max = 456);

        $range = $this->factory->fromAggregator($aggregator, $step = 213);
        $this->assertSame($min, $range->getMin());
        $this->assertSame($max, $range->getMax());
        $this->assertSame($step, $range->getStep());
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->factory = new RangeFactory;
    }
}

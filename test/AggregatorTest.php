<?php

namespace CBH\DataBaseIterator;

use CBH\DataBaseIterator\ValueObject\AggregationInfo;

class AggregatorTest extends \PHPUnit_Framework_TestCase
{
    /** @var Aggregator */
    private $aggregator;

    /** @var SelectorInterface */
    private $selector;

    /**
     * @covers \CBH\DataBaseIterator\Aggregator::__construct
     * @covers \CBH\DataBaseIterator\Aggregator::getInfo
     * @throws Exception\InvalidArgument
     */
    public function testGetInfo()
    {
        $this->selector
            ->expects($this->once())
            ->method('aggregate')
            ->willReturn(
                $info = $this->createMock(
                    AggregationInfo::class
                )
            );

        $this->assertSame($info, $this->aggregator->getInfo());
        // Cached
        $this->assertSame($info, $this->aggregator->getInfo());
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->aggregator = new Aggregator(
            $this->selector = $this->createMock(
                SelectorInterface::class
            )
        );
    }
}

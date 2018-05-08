<?php

namespace CBH\DataBaseIterator\ValueObject;

class AggregationInfoTest extends \PHPUnit_Framework_TestCase
{
    /** @var AggregationInfo */
    private $info;
    /** @var integer */
    private $min;
    /** @var integer */
    private $max;
    /** @var integer */
    private $total;

    /**
     * @covers \CBH\DataBaseIterator\ValueObject\AggregationInfo::__construct
     * @covers \CBH\DataBaseIterator\ValueObject\AggregationInfo::getMax
     */
    public function testGetMax()
    {
        $this->assertSame($this->max, $this->info->getMax());
    }

    /**
     * @covers \CBH\DataBaseIterator\ValueObject\AggregationInfo::__construct
     * @covers \CBH\DataBaseIterator\ValueObject\AggregationInfo::getTotal
     */
    public function testGetTotal()
    {
        $this->assertSame($this->total, $this->info->getTotal());
    }

    /**
     * @covers \CBH\DataBaseIterator\ValueObject\AggregationInfo::__construct
     * @covers \CBH\DataBaseIterator\ValueObject\AggregationInfo::getMin
     */
    public function testGetMin()
    {
        $this->assertSame($this->min, $this->info->getMin());
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->info = new AggregationInfo(
            $this->min,
            $this->max,
            $this->total
        );
    }
}

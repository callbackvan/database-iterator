<?php

namespace CBH\DataBaseIterator;

class RangeTest extends \PHPUnit_Framework_TestCase
{
    /** @var Range */
    private $range;

    /** @var integer */
    private $min;
    /** @var integer */
    private $max;
    /** @var integer */
    private $step;

    /**
     * @covers \CBH\DataBaseIterator\Range::__construct
     * @covers \CBH\DataBaseIterator\Range::getStep
     */
    public function testGetStep()
    {
        $this->assertSame($this->step, $this->range->getStep());
    }

    /**
     * @covers \CBH\DataBaseIterator\Range::__construct
     * @covers \CBH\DataBaseIterator\Range::getMin
     */
    public function testGetMin()
    {
        $this->assertSame($this->min, $this->range->getMin());
    }

    /**
     * @covers \CBH\DataBaseIterator\Range::__construct
     * @covers \CBH\DataBaseIterator\Range::getMax
     */
    public function testGetMax()
    {
        $this->assertSame($this->max, $this->range->getMax());
    }

    /**
     * @covers \CBH\DataBaseIterator\Range::__construct
     * @covers \CBH\DataBaseIterator\Range::getFrom
     */
    public function testGetFromDefault()
    {
        $this->assertSame($this->min, $this->range->getFrom());
    }

    /**
     * @covers \CBH\DataBaseIterator\Range::next
     * @covers \CBH\DataBaseIterator\Range::getTo
     * @covers \CBH\DataBaseIterator\Range::hasNext
     */
    public function testNext()
    {
        $from = $this->min; // 10
        $to = $from + $this->step; // 10 + 50 = 60

        $this->assertSame($from, $this->range->getFrom());
        $this->assertSame($to, $this->range->getTo());
        $this->assertTrue($this->range->hasNext());
        $this->range->next();

        $from = $to + 1; // 61
        $to = $from + $this->step; // 61 + 50 = 111

        $this->assertSame($from, $this->range->getFrom());
        $this->assertSame($to, $this->range->getTo());
        $this->assertTrue($this->range->hasNext());
        $this->range->next();

        $from = $to + 1; // 112
        $to = $from + $this->step; // 112 + 50 = 162

        $this->assertSame($from, $this->range->getFrom());
        $this->assertSame($to, $this->range->getTo());
        $this->assertTrue($this->range->hasNext());
        $this->range->next();

        $from = $to + 1; // 163
        $to = $from + $this->step; // 163 + 50 = 213 === max

        $this->assertSame($from, $this->range->getFrom());
        $this->assertSame($to, $this->range->getTo());
        $this->assertFalse($this->range->hasNext()); // 213
    }

    /**
     * @covers \CBH\DataBaseIterator\Range::next
     * @covers \CBH\DataBaseIterator\Range::getTo
     * @covers \CBH\DataBaseIterator\Range::hasNext
     */
    public function testNextWhenSingleRow()
    {
        $this->range = new Range(
            $this->min = 1,
            $this->max = 1,
            $this->step = 50
        );
        $from = $this->min; // 1
        // $to = $from + $this->step; // 1 + 50 = 51 > max

        $this->assertSame($from, $this->range->getFrom());
        $this->assertSame($this->max, $this->range->getTo());
        $this->assertFalse($this->range->hasNext());
    }

    /**
     * @covers \CBH\DataBaseIterator\Range::rewind
     */
    public function testRewind()
    {
        $from = $this->min; // 10
        $to = $from + $this->step; // 10 + 50 = 60

        $this->assertSame($from, $this->range->getFrom());
        $this->assertSame($to, $this->range->getTo());
        $this->assertTrue($this->range->hasNext());
        $this->range->next();

        $from = $to + 1; // 61
        $to = $from + $this->step; // 61 + 50 = 111

        $this->assertSame($from, $this->range->getFrom());
        $this->assertSame($to, $this->range->getTo());
        $this->assertTrue($this->range->hasNext());
        $this->range->rewind();

        $from = $this->min; // 10
        $to = $from + $this->step; // 10 + 50 = 60

        $this->assertSame($from, $this->range->getFrom());
        $this->assertSame($to, $this->range->getTo());
        $this->assertTrue($this->range->hasNext());
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->range = new Range(
            $this->min = 10,
            $this->max = 213,
            $this->step = 50
        );
    }
}

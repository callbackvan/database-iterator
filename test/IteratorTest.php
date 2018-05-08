<?php

namespace CBH\DataBaseIterator;


class IteratorTest extends \PHPUnit_Framework_TestCase
{
    /** @var Iterator */
    private $iterator;

    /** @var SelectorInterface */
    private $selector;

    /** @var RangeInterface */
    private $range;

    /**
     * @covers \CBH\DataBaseIterator\Iterator::__construct
     * @covers \CBH\DataBaseIterator\Iterator::current
     * @covers \CBH\DataBaseIterator\Iterator::next
     * @covers \CBH\DataBaseIterator\Iterator::key
     * @covers \CBH\DataBaseIterator\Iterator::valid
     * @covers \CBH\DataBaseIterator\Iterator::rewind
     * @covers \CBH\DataBaseIterator\Iterator::load
     */
    public function testIterator()
    {
        $expected = array_map(
            function ($number) {
                return ["Item #{$number}"];
            },
            range(0, 99)
        );

        $this->selector
            ->expects($this->exactly(5))
            ->method('load')
            ->with($this->range)
            ->willReturn(
            // has 10 elements
                $this->makeGenerator(array_slice($expected, 0, 10)),
                // is empty
                $this->makeGenerator([]),
                // has 20 elements
                $this->makeGenerator(array_slice($expected, 10, 20)),
                // has 70 elements
                $this->makeGenerator(array_slice($expected, 30, 70)),
                // is empty
                $this->makeGenerator([])
            );

        $this->range
            ->expects($this->exactly(5))
            ->method('next');

        $this->range
            ->expects($this->once())
            ->method('rewind');

        $this->range
            // 1st time, when 1st empty generator was returned
            // 2nd time, when 2nd empty generator was returned
            // 3rd time, when called method \CBH\DataBaseIterator\Iterator::valid
            ->expects($this->exactly(3))
            ->method('hasNext')
            ->willReturn(true, false, false);

        $counter = 0;

        foreach ($this->iterator as $key => $value) {
            $this->assertSame($this->calculateExpectedKey($counter), $key);
            $this->assertSame($expected[$counter++], $value);
        }
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->iterator = new Iterator(
            $this->selector = $this->createMock(
                SelectorInterface::class
            ),
            $this->range = $this->createMock(
                RangeInterface::class
            )
        );
    }

    /**
     * @param array $elements
     *
     * @return \Generator
     */
    private function makeGenerator(array $elements)
    {
        foreach ($elements as $element) {
            yield $element;
        }
    }

    /**
     * Describes the definition of $key value
     * In each generator, the numbering starts from zero
     *
     * @param $counter
     *
     * @return int
     */
    private function calculateExpectedKey($counter)
    {
        switch (true) {
            case $counter >= 30:
                $expectedKey = $counter - 30;
                break;
            case $counter >= 10:
                $expectedKey = $counter - 10;
                break;
            default:
                $expectedKey = $counter;
                break;
        }

        return $expectedKey;
    }
}

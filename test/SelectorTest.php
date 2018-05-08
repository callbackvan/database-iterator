<?php

namespace CBH\DataBaseIterator;

use PHPUnit\Framework\TestCase;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Adapter\Driver\StatementInterface;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Between;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

class SelectorTest extends TestCase
{
    /** @var Selector */
    private $selector;

    /** @var \Zend\Db\Sql\Sql */
    private $sql;
    /** @var string */
    private $table;
    /** @var \Zend\Db\Sql\Where|\Closure|string|array|\Zend\Db\Sql\Predicate\PredicateInterface */
    private $criteria;
    /** @var string */
    private $iterateOver;
    /** @var array */
    private $fields;

    /**
     * @covers \CBH\DataBaseIterator\Selector::__construct
     * @covers \CBH\DataBaseIterator\Selector::load
     * @throws \CBH\DataBaseIterator\Exception\InvalidArgument
     */
    public function testLoad()
    {
        $range = $this->createMock(RangeInterface::class);
        $range
            ->expects($this->once())
            ->method('getFrom')
            ->willReturn($from = 12);
        $range
            ->expects($this->once())
            ->method('getTo')
            ->willReturn($to = 987);


        $this->sql
            ->expects($this->once())
            ->method('select')
            ->with($this->table)
            ->willReturn(
                $select = $this->createMock(Select::class)
            );

        $select
            ->expects($this->once())
            ->method('columns')
            ->with($this->fields)
            ->willReturnSelf();

        $select
            ->expects($this->exactly(2))
            ->method('where')
            ->withConsecutive(
                [$this->criteria],
                [
                    $this->callback(
                        function ($criteria) use ($from, $to) {
                            $this->assertInternalType('array', $criteria);
                            $this->assertCount(1, $criteria);
                            $this->assertArrayHasKey(0, $criteria);
                            /** @var Between $predicate */
                            $predicate = reset($criteria);
                            $this->assertInstanceOf(Between::class, $predicate);
                            $this->assertSame(
                                $this->iterateOver,
                                $predicate->getIdentifier()
                            );

                            $this->assertSame($from, $predicate->getMinValue());
                            $this->assertSame($to, $predicate->getMaxValue());

                            return true;
                        }
                    ),
                ]
            )
            ->willReturnSelf();

        $this->sql
            ->expects($this->once())
            ->method('prepareStatementForSqlObject')
            ->with($select)
            ->willReturn(
                $statement = $this->createMock(
                    StatementInterface::class
                )
            );

        $statement
            ->expects($this->once())
            ->method('execute')
            ->willReturn(
                $result = $this->createMock(
                    ResultInterface::class
                )
            );

        $expected = [
            ['item 0'],
            ['item 1'],
            ['item 2'],
            ['item 3'],
        ];

        $this->prepareResult($result, $expected);

        $counter = 0;
        foreach ($this->selector->load($range) as $item) {
            $this->assertSame($expected[$counter++], $item);
        }
    }

    /**
     * @covers \CBH\DataBaseIterator\Selector::__construct
     * @covers \CBH\DataBaseIterator\Selector::load
     * @expectedException  \CBH\DataBaseIterator\Exception\InvalidArgument
     */
    public function testLoadThrowInvalidArgumentException()
    {
        $this->sql
            ->expects($this->once())
            ->method('select')
            ->willThrowException(
                $this->createMock(
                    \Zend\Db\Sql\Exception\InvalidArgumentException::class
                )
            );

        $this->selector
            ->load($this->createMock(RangeInterface::class))
            ->rewind();
    }

    /**
     * @covers \CBH\DataBaseIterator\Selector::__construct
     * @covers \CBH\DataBaseIterator\Selector::aggregate
     * @throws \CBH\DataBaseIterator\Exception\InvalidArgument
     */
    public function testAggregate()
    {
        $this->sql
            ->expects($this->once())
            ->method('select')
            ->with($this->table)
            ->willReturn(
                $select = $this->createMock(Select::class)
            );

        $select
            ->expects($this->once())
            ->method('columns')
            ->with(
                $this->callback(
                    function ($fields) {
                        $this->assertInternalType('array', $fields);
                        $this->assertArrayHasKey('min', $fields);
                        /** @var Expression $min */
                        $min = $fields['min'];
                        $this->assertInstanceOf(
                            Expression::class,
                            $min
                        );
                        $this->assertNotFalse(
                            strpos($min->getExpression(), $this->iterateOver)
                        );
                        $this->assertArrayHasKey('max', $fields);
                        /** @var Expression $max */
                        $max = $fields['max'];
                        $this->assertInstanceOf(
                            Expression::class,
                            $max
                        );
                        $this->assertNotFalse(
                            strpos($max->getExpression(), $this->iterateOver)
                        );
                        $this->assertArrayHasKey('total', $fields);
                        $this->assertInstanceOf(
                            Expression::class,
                            $fields['total']
                        );

                        return true;
                    }
                )
            )
            ->willReturnSelf();

        $select
            ->expects($this->once())
            ->method('where')
            ->with($this->criteria)
            ->willReturnSelf();

        $this->sql
            ->expects($this->once())
            ->method('prepareStatementForSqlObject')
            ->with($select)
            ->willReturn(
                $statement = $this->createMock(
                    StatementInterface::class
                )
            );

        $statement
            ->expects($this->once())
            ->method('execute')
            ->willReturn(
                $result = $this->createMock(
                    ResultInterface::class
                )
            );

        $min = 12;
        $max = 987;
        $total = 35;

        $this->prepareResult($result, [compact('min', 'max', 'total')]);

        $info = $this->selector->aggregate();
        $this->assertSame($min, $info->getMin());
        $this->assertSame($max, $info->getMax());
        $this->assertSame($total, $info->getTotal());
    }

    /**
     * @covers \CBH\DataBaseIterator\Selector::__construct
     * @covers \CBH\DataBaseIterator\Selector::aggregate
     * @expectedException  \CBH\DataBaseIterator\Exception\InvalidArgument
     */
    public function testAggregateThrowInvalidArgumentException()
    {
        $this->sql
            ->expects($this->once())
            ->method('select')
            ->willThrowException(
                $this->createMock(
                    \Zend\Db\Sql\Exception\InvalidArgumentException::class
                )
            );

        $this->selector->aggregate();
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->selector = new Selector(
            $this->sql = $this->createMock(Sql::class),
            $this->table = 'table',
            $this->criteria = 'criteria',
            $this->iterateOver = 'iterateOver',
            $this->fields = ['one', 'two', 'three']
        );
    }

    /**
     * @param ResultInterface|\PHPUnit_Framework_MockObject_MockObject $result
     * @param array                                                    $expected
     *
     * @return mixed
     */
    private function prepareResult(ResultInterface $result, array $expected)
    {
        $result
            ->expects($this->once())
            ->method('isQueryResult')
            ->willReturn(true);
        $expectedCount = count($expected);

        $result
            ->expects($this->once())
            ->method('rewind')
            ->willReturnCallback(
                function () use (&$expected) {
                    reset($expected);
                }
            );

        $validCounter = 0;
        $result
            ->expects($this->exactly($expectedCount + 1))
            ->method('valid')
            ->willReturnCallback(
                function () use ($expectedCount, &$validCounter) {
                    return ++$validCounter <= $expectedCount;
                }
            );

        $result
            ->expects($this->exactly($expectedCount))
            ->method('current')
            ->willReturnCallback(
                function () use (&$expected) {
                    $result = current($expected);
                    next($expected);

                    return $result;
                }
            );

        return $expected;
    }
}

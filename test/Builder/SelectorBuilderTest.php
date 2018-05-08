<?php

namespace CBH\DataBaseIterator\Builder;

use CBH\DataBaseIterator\SelectorInterface;
use Zend\Db\Sql\Sql;

class SelectorBuilderTest extends \PHPUnit_Framework_TestCase
{
    /** @var SelectorBuilder */
    private $builder;

    /**
     * @covers \CBH\DataBaseIterator\Builder\SelectorBuilder::getSelector
     * @covers \CBH\DataBaseIterator\Builder\SelectorBuilder::setSql
     * @covers \CBH\DataBaseIterator\Builder\SelectorBuilder::setTable
     * @covers \CBH\DataBaseIterator\Builder\SelectorBuilder::setCriteria
     * @covers \CBH\DataBaseIterator\Builder\SelectorBuilder::setIterateOver
     * @covers \CBH\DataBaseIterator\Builder\SelectorBuilder::setFields
     * @throws \CBH\DataBaseIterator\Exception\BuilderNotFullFilled
     */
    public function testGetSelector()
    {
        $this->builder
            ->setSql($this->createMock(Sql::class));
        $this->builder
            ->setTable('table');
        $this->builder
            ->setCriteria('criteria');
        $this->builder
            ->setIterateOver('over id');
        $this->builder
            ->setFields(['field1', 'field2']);

        $this->assertInstanceOf(
            SelectorInterface::class,
            $this->builder->getSelector()
        );
    }

    /**
     * @covers \CBH\DataBaseIterator\Builder\SelectorBuilder::getSelector
     * @expectedException \CBH\DataBaseIterator\Exception\BuilderNotFullFilled
     */
    public function testGetSelectorThrowsRuntime()
    {
        $this->builder->getSelector();
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->builder = new SelectorBuilder;
    }
}

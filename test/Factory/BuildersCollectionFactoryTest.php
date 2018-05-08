<?php

namespace CBH\DataBaseIterator\Factory;

use CBH\DataBaseIterator\Collection\BuildersCollection;

class BuildersCollectionFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var BuildersCollectionFactory */
    private $factory;

    /**
     * @covers \CBH\DataBaseIterator\Factory\BuildersCollectionFactory::make
     */
    public function testMake()
    {
        $this->assertInstanceOf(
            BuildersCollection::class,
            $this->factory->make()
        );
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->factory = new BuildersCollectionFactory;
    }
}

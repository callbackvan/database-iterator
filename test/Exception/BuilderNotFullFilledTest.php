<?php

namespace CBH\DataBaseIterator\Exception;

class BuilderNotFullFilledTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \CBH\DataBaseIterator\Exception\BuilderNotFullFilled::__construct
     */
    public function test__construct()
    {
        $this->assertSame(
            'Not all required objects was set',
            (new BuilderNotFullFilled)->getMessage()
        );
    }
}

<?php

namespace CBH\DataBaseIterator\Builder;

use CBH\DataBaseIterator\Exception;
use CBH\DataBaseIterator\Iterator;
use CBH\DataBaseIterator\RangeInterface;
use CBH\DataBaseIterator\SelectorInterface;

class IteratorBuilder
{
    /** @var SelectorInterface */
    private $selector;
    /** @var RangeInterface */
    private $range;

    /**
     * @param SelectorInterface $selector
     *
     * @return IteratorBuilder
     */
    public function setSelector($selector)
    {
        $this->selector = $selector;

        return $this;
    }

    /**
     * @param RangeInterface $range
     *
     * @return IteratorBuilder
     */
    public function setRange($range)
    {
        $this->range = $range;

        return $this;
    }

    /**
     * @throws \CBH\DataBaseIterator\Exception\BuilderNotFullFilled
     *
     * @return Iterator
     */
    public function getIterator()
    {
        if (!isset($this->selector, $this->range)) {
            throw new Exception\BuilderNotFullFilled;
        }

        return new Iterator($this->selector, $this->range);
    }
}

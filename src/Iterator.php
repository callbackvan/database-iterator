<?php

namespace CBH\DataBaseIterator;

class Iterator implements \Iterator
{
    /** @var SelectorInterface */
    private $selector;
    /** @var RangeInterface */
    private $range;
    /** @var \Generator */
    private $data;

    /**
     * Iterator constructor.
     *
     * @param SelectorInterface $selector
     * @param RangeInterface    $range
     */
    public function __construct(
        SelectorInterface $selector,
        RangeInterface $range
    ) {
        $this->selector = $selector;
        $this->range = $range;
    }


    /**
     * Return the current element
     *
     * @link  http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->data->current();
    }

    /**
     * Move forward to next element
     *
     * @link  http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->data->next();
        if (false === $this->data->valid()) {
            $this->load();
        }
    }

    /**
     * Return the key of the current element
     *
     * @link  http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->data->key();
    }

    /**
     * Checks if current position is valid
     *
     * @link  http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return $this->data->valid() || $this->range->hasNext();
    }

    /**
     * Rewind the Iterator to the first element
     *
     * @link  http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->range->rewind();
        $this->load();
    }

    /**
     * Load data from database
     *
     * @return void
     */
    private function load()
    {
        do {
            $this->data = $this->selector->load($this->range);
            $this->range->next();
        } while (!$this->data->valid() && $this->range->hasNext());
    }
}

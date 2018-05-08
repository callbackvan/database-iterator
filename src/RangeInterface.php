<?php

namespace CBH\DataBaseIterator;

interface RangeInterface
{
    /**
     * @return int
     */
    public function getFrom();

    /**
     * @return int
     */
    public function getTo();

    /**
     * Move cursor to start position
     *
     * @return void
     */
    public function rewind();

    /**
     * Move to next step
     *
     * @return void
     */
    public function next();

    /**
     * Does the maximum is reached
     *
     * @return boolean
     */
    public function hasNext();
}

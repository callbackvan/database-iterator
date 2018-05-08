<?php

namespace CBH\DataBaseIterator;

class Range implements RangeInterface
{
    /** @var integer */
    private $min;
    /** @var integer */
    private $max;
    /** @var integer */
    private $step;
    /** @var integer */
    private $from;

    /**
     * Range constructor.
     *
     * @param int $min
     * @param int $max
     * @param int $step
     */
    public function __construct($min, $max, $step)
    {
        $this->min = $min;
        $this->max = $max;
        $this->step = $step;
        $this->rewind();
    }

    /**
     * @return int
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * @return int
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @return int
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * @return int
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return int
     */
    public function getTo()
    {
        return min($this->from + $this->step, $this->max);
    }

    /**
     * Move cursor to start position
     *
     * @return void
     */
    public function rewind()
    {
        $this->from = $this->min;
    }

    /**
     * Move to next step
     *
     * @return void
     */
    public function next()
    {
        $this->from = min($this->from + $this->step + 1, $this->max);
    }

    /**
     * Does the maximum is reached
     *
     * @return boolean
     */
    public function hasNext()
    {
        return $this->getTo() !== $this->max;
    }
}

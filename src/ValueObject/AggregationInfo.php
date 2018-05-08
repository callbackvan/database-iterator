<?php

namespace CBH\DataBaseIterator\ValueObject;

class AggregationInfo
{
    /** @var integer */
    private $min;
    /** @var integer */
    private $max;
    /** @var integer */
    private $total;

    /**
     * AggregationInfo constructor.
     *
     * @param int $min
     * @param int $max
     * @param int $total
     */
    public function __construct($min, $max, $total)
    {
        $this->min = $min;
        $this->max = $max;
        $this->total = $total;
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
    public function getTotal()
    {
        return $this->total;
    }
}

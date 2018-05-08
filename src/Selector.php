<?php

namespace CBH\DataBaseIterator;

use CBH\DataBaseIterator\ValueObject\AggregationInfo;
use Zend\Db\Sql\Predicate\Between;

class Selector implements SelectorInterface
{
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
     * Selector constructor.
     *
     * @param \Zend\Db\Sql\Sql                                                                   $sql
     * @param string                                                                             $table
     * @param array|\Closure|string|\Zend\Db\Sql\Predicate\PredicateInterface|\Zend\Db\Sql\Where $criteria
     * @param string                                                                             $iterateOver
     * @param array                                                                              $fields
     */
    public function __construct(
        \Zend\Db\Sql\Sql $sql,
        $table,
        $criteria,
        $iterateOver = 'id',
        array $fields = ['*']
    ) {
        $this->sql = $sql;
        $this->table = $table;
        $this->criteria = $criteria;
        $this->iterateOver = $iterateOver;
        $this->fields = $fields;
    }


    /**
     * Load next package of data from database
     *
     * @param RangeInterface $range
     *
     * @throws \CBH\DataBaseIterator\Exception\InvalidArgument
     *
     * @return \Generator
     */
    public function load(RangeInterface $range)
    {
        try {
            $select = $this->sql
                ->select($this->table)
                ->columns($this->fields)
                ->where($this->criteria);

            $select
                ->where(
                    [
                        new Between(
                            $this->iterateOver,
                            $range->getFrom(),
                            $range->getTo()
                        ),
                    ]
                );
        } catch (\Zend\Db\Sql\Exception\InvalidArgumentException $ex) {
            throw new Exception\InvalidArgument(
                $ex->getMessage(),
                $ex->getCode(),
                $ex
            );
        }

        $result = $this->sql
            ->prepareStatementForSqlObject($select)
            ->execute();

        if ($result->isQueryResult()) {
            foreach ($result as $item) {
                yield $item;
            }
        }
    }

    /**
     * Aggregate info with criteria
     *
     * @throws \CBH\DataBaseIterator\Exception\InvalidArgument
     *
     * @return AggregationInfo
     */
    public function aggregate()
    {
        $fields = [
            'min'   => "min({$this->iterateOver})",
            'max'   => "max({$this->iterateOver})",
            'total' => 'count(*)',
        ];

        try {
            $select = $this->sql
                ->select($this->table)
                ->columns($fields)
                ->where($this->criteria);
        } catch (\Zend\Db\Sql\Exception\InvalidArgumentException $ex) {
            throw new Exception\InvalidArgument(
                $ex->getMessage(),
                $ex->getCode(),
                $ex
            );
        }

        $result = $this->sql
            ->prepareStatementForSqlObject($select)
            ->execute();

        $min = $max = $total = 0;
        if ($result->isQueryResult()) {
            foreach ($result as $item) {
                if (isset($item['min'])) {
                    $min = (int)$item['min'];
                }
                if (isset($item['max'])) {
                    $max = (int)$item['max'];
                }
                if (isset($item['total'])) {
                    $total = (int)$item['total'];
                }
            }
        }

        return new AggregationInfo($min, $max, $total);
    }
}

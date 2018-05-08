<?php

namespace CBH\DataBaseIterator\Builder;

use CBH\DataBaseIterator\Exception;
use CBH\DataBaseIterator\Selector;
use CBH\DataBaseIterator\SelectorInterface;

class SelectorBuilder
{
    /** @var \Zend\Db\Sql\Sql */
    private $sql;
    /** @var string */
    private $table;
    /** @var \Zend\Db\Sql\Where|\Closure|string|array|\Zend\Db\Sql\Predicate\PredicateInterface */
    private $criteria = [];
    /** @var string */
    private $iterateOver = 'id';
    /** @var array */
    private $fields = ['*'];

    /**
     * @param \Zend\Db\Sql\Sql $sql
     *
     * @return SelectorBuilder
     */
    public function setSql($sql)
    {
        $this->sql = $sql;

        return $this;
    }

    /**
     * @param string $table
     *
     * @return SelectorBuilder
     */
    public function setTable($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @param array|\Closure|string|\Zend\Db\Sql\Predicate\PredicateInterface|\Zend\Db\Sql\Where $criteria
     *
     * @return SelectorBuilder
     */
    public function setCriteria($criteria)
    {
        $this->criteria = $criteria;

        return $this;
    }

    /**
     * @param string $iterateOver
     *
     * @return SelectorBuilder
     */
    public function setIterateOver($iterateOver)
    {
        $this->iterateOver = $iterateOver;

        return $this;
    }

    /**
     * @param array $fields
     *
     * @return SelectorBuilder
     */
    public function setFields($fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @throws \CBH\DataBaseIterator\Exception\BuilderNotFullFilled
     *
     * @return SelectorInterface
     */
    public function getSelector()
    {
        if (!isset($this->sql, $this->table)) {
            throw new Exception\BuilderNotFullFilled;
        }

        return new Selector(
            $this->sql,
            $this->table,
            $this->criteria,
            $this->iterateOver,
            $this->fields
        );
    }
}

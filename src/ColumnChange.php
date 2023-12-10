<?php

namespace Polashmahmud\History;

class ColumnChange
{
    /**
     * @var
     */
    public $column;
    /**
     * @var
     */
    public $from;
    /**
     * @var
     */
    public $to;

    /**
     * @param $column
     * @param $from
     * @param $to
     */
    public function __construct($column, $from, $to)
    {
        $this->column = $column;
        $this->from = $from;
        $this->to = $to;
    }
}

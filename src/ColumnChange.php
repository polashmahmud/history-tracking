<?php

namespace Polashmahmud\History;

class ColumnChange
{
    public $column;
    public $from;
    public $to;

    public function __construct($column, $from, $to)
    {
        $this->column = $column;
        $this->from = $from;
        $this->to = $to;
    }

}

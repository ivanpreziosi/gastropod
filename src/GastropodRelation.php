<?php

namespace RadFic\Gastropod;

class GastropodRelation
{
    const TYPE_11 = 100;
    const TYPE_1N = 200;
    const TYPE_N1 = 300;
    const TYPE_NN = 400;

    public $model;
    public $field;
    public $key;
    public $type;

    public function __construct($type = GastropodRelation::TYPE_11, $model, $field, $key)
    {
        $this->type = $type;
        $this->key = $key;
        $this->model = $model;
        $this->field = $field;
    }
}

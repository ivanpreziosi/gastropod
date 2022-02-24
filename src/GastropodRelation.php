<?php

namespace RadFic\Gastropod;

class GastropodRelation
{
    const TYPE_11 = 100;
    const TYPE_1N = 200;
    const TYPE_N1 = 300;
    const TYPE_NN = 400;

	public $name;
    public $model;
    public $field;
    public $key;
    public $type;

	static function create($name, $model, $field, $key, $type = GastropodRelation::TYPE_11){
		return new GastropodRelation($name, $model, $field, $key, $type);
	}

    public function __construct($name, $model, $field, $key, $type = GastropodRelation::TYPE_11)
    {
        $this->name = $name;
        $this->type = $type;
        $this->key = $key;
        $this->model = $model;
        $this->field = $field;
    }
}

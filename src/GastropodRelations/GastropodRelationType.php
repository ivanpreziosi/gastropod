<?php

namespace RadFic\Gastropod\GastropodRelations;


class GastropodRelationType{
	public $type = "base";
	public $relationData;

	public function __construct($relationData){
		$this->relationData = $relationData;
	}
}
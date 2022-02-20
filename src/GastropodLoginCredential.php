<?php

namespace RadFic\Gastropod;

class GastropodLoginCredential{

	const INPUT_REQUEST = 10;

	public $name;
	public $type;
	public $key;

	public function __construct($type,$key){
        $this->type = $type;
        $this->key = $key;
	}
}

<?php

namespace RadFic\Gastropod\GastropodWidgets;

class GastropodDropdownWidget extends GastropodBaseWidget
{
	public $options;
	public $selectedOption;

	public function render(){
		return view('gastropod.widgets.dropdown', [
			'columnName' => $this->columnName,
			'options' => $this->options,
			'selectedOption' => $this->selectedOption,
		])->render();
	}
}

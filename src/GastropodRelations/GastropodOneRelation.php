<?php

namespace RadFic\Gastropod\GastropodRelations;

use RadFic\Gastropod\GastropodWidgets\GastropodBaseWidget;
use RadFic\Gastropod\GastropodWidgets\GastropodDropdownWidget;

class GastropodOneRelation extends GastropodRelationType
{
    public $type = "one";

    public function __construct($relationData)
    {
        parent::__construct($relationData);
    }

    public function index($item)
    {
        $key = $this->relationData->key;
        $relationName = $this->relationData->name;
        $relatedField = $this->relationData->field;

        $relation = $item->$relationName;
        $relationTable = $relation->getTable();
            
        $fieldValue = ($relation!= null)?$relation->$relatedField:"";
        $newFieldName = $relationName."_".$relatedField."__REMOTE";
        $item->$newFieldName = "<a href='/gastropod/$relationTable/$relation->id'>$fieldValue</a>";
    }


    public function create($columnName)
    {
        $widget = null;
        if ($relationData->key == $columnName) {
            $widget = new GastropodDropdownWidget();
            $widget->columnName = $columnName;
            $widget->options = array();

            $dropdownData = $relationData->model::get();
            foreach ($dropdownData as $dd) {
                $ddText = $relationData->field;
                $widget->options[] = [
					'value' => $dd->id,
					'text' => $dd->$ddText,
				];
            }
        }
		return $widget;
    }
}

<?php

namespace RadFic\Gastropod;

/**
 * Represents a relation between two models.
 *
 * Will be defined in controllers to specify type and properties of each relevant relation.
 */
class GastropodRelation
{
    /** Relations type constants*/
    /** @var int TYPE_11 Relation type one to one */
    const TYPE_11 = 100;
    /** @var int TYPE_1N Relation type one to many */
    const TYPE_1N = 200;
    /** @var int TYPE_N1 Relation type many to one */
    const TYPE_N1 = 300;
    /** @var int TYPE_NN Relation type many to many */
    const TYPE_NN = 400;

    /** @var string $name Relation name in main Model definition  */
    public $name;
    /** @var string $model The Eloquent model of the referenced table */
    public $model;
    /** @var string $field The name of the field we want to show in our crud */
    public $field;
    /** @var string $key Is the name of the field holding reference to the other class id */
    public $key;
    /** @var int $type Is the type of the relation (TYPE_11,TYPE_1N,TYPE_N1,TYPE_NN) */
    public $type;

    /**
     * Static creator function
     * 
     * @param string $name Relation name in main Model definition
     * @param string $model The Eloquent model of the referenced table
     * @param string $field The name of the field we want to show in our crud
     * @param string $key Is the name of the field holding reference to the other class id
     * @param int $type Is the type of the relation (TYPE_11,TYPE_1N,TYPE_N1,TYPE_NN)
     */
    public static function create($name, $model, $field, $key, $type = GastropodRelation::TYPE_11)
    {
        return new GastropodRelation($name, $model, $field, $key, $type);
    }

    /**
     * Contructor
     *
     * @param string $name Relation name in main Model definition
     * @param string $model The Eloquent model of the referenced table
     * @param string $field The name of the field we want to show in our crud
     * @param string $key Is the name of the field holding reference to the other class id
     * @param int $type Is the type of the relation (TYPE_11,TYPE_1N,TYPE_N1,TYPE_NN)
     */
    public function __construct($name, $model, $field, $key, $type = GastropodRelation::TYPE_11)
    {
        $this->name = $name;
        $this->type = $type;
        $this->key = $key;
        $this->model = $model;
        $this->field = $field;
    }
}

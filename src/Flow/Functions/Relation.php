<?php

namespace PHell\Flow\Functions;

class Relation
{

    public const RELATION_OBJECT_INNER_ACCESS = 'inner';
//    public const RELATION_OBJECT_INNER_PARENT_ACCESS = 'parent';
    public const RELATION_OBJECT_OUTER_ACCESS = 'outer';

    private FunctionObject $object;
    private string $relation;

    public function __construct(FunctionObject $object, string $relation)
    {
        $this->object = $object;
        $this->relation = $relation;
    }

    /**
     * @return FunctionObject
     */
    public function getObject(): FunctionObject
    {
        return $this->object;
    }

    /**
     * @return string
     */
    public function getRelation(): string
    {
        return $this->relation;
    }
}
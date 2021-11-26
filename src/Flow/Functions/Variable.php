<?php

namespace PHell\Flow\Functions;

use PHell\Code\Statement;

class Variable implements Statement
{

    private string $name;

    private ?Relation $relation;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param Relation|null $relation
     */
    public function setRelation(?Relation $relation): void
    {
        $this->relation = $relation;
    }

    public function getValue()
    {
        if ($this->relation !== null)  {
            if ($this->relation->getRelation() === Relation::RELATION_OBJECT_INNER_ACCESS) {
                $this->relation->getObject()->getObjectInnerVar($this->name);
            }
            if ($this->relation->getRelation() === Relation::RELATION_OBJECT_OUTER_ACCESS) {
                $this->relation->getObject()->getObjectOuterVar($this->name);
            }
        }
        Runtime::get()->current()->getOriginatorVar($this->name);
    }

    public function setValue($value)
    {
        if ($this->relation !== null)  {
            if ($this->relation->getRelation() === Relation::RELATION_OBJECT_INNER_ACCESS) {
                $this->relation->getObject()->setObjectInnerVar($this->name, $value);
            }
            if ($this->relation->getRelation() === Relation::RELATION_OBJECT_OUTER_ACCESS) {
                $this->relation->getObject()->setObjectOuterVar($this->name, $value);
            }
        }
        Runtime::get()->current()->setOriginatorVar($this->name, $value);

        return $value;
    }


}
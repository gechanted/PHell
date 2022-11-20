<?php

namespace PHell\Flow\Data\Datatypes;

use PHell\Exceptions\ShouldntHappenException;

class DatatypeConstructAND extends DatatypeConstructOR
{

    /**
     * @param DatatypeInterface[] $datatypes
     */
    public function __construct(private readonly array $datatypes)
    {
        parent::__construct($this->datatypes);
    }

    public function realValidate(DatatypeInterface $givenIn): DatatypeValidation
    {
        return parent::isA($givenIn);
    }

    public function dumpType(): string
    {
        $result = '';
        foreach ($this->datatypes as $type) {
            if ($result !== '') {
                $result .= ' && ';
            }
            $result .= $type->dumpType();
        }
        return '(' . $result . ')';
    }

    public function isA(DatatypeInterface $givenIn): DatatypeValidation
    {
        return parent::realValidate($givenIn);
    }
}
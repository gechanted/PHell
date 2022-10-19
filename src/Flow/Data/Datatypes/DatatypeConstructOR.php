<?php

namespace PHell\Flow\Data\Datatypes;

use PHell\Flow\Data\DatatypeValidators\DatatypeValidatorConstructOR;

class DatatypeConstructOR extends DatatypeValidatorConstructOR implements DatatypeInterface
{

    /**
     * @param DatatypeInterface[] $type
     */
    public function __construct(private readonly array $type)
    {
        parent::__construct($this->type);
    }

    public function getNames(): array
    {
//        foreach ($this->type as $datatype) {
//            $datatype->getNames();
//        }

        //TODO getNames(): string[]   is not sufficient. The return type kinda has to contain the OR operator to tell the Validator that
    }
}
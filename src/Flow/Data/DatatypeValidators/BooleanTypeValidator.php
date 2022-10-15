<?php

namespace PHell\Flow\Data\DatatypeValidators;

use PHell\Flow\Data\Datatypes\DatatypeInterface;

class BooleanTypeValidator implements DatatypeValidatorInterface
{
    const TYPE_BOOLEAN = 'boolean';

    public function validate(DatatypeInterface $datatype): DatatypeValidation
    {
        //TODO think about depth
        return new DatatypeValidation(in_array(self::TYPE_BOOLEAN, $datatype->getNames(), true), 0);
    }

}
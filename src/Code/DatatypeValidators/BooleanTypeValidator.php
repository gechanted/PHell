<?php

namespace PHell\Code\DatatypeValidators;

use PHell\Flow\Datatypes\DatatypeInterface;

class BooleanTypeValidator implements DatatypeValidatorInterface
{
    const TYPE_BOOLEAN = 'boolean';

    public function validate(DatatypeInterface $datatype): DatatypeValidation
    {
        return new DatatypeValidation(in_array(self::TYPE_BOOLEAN, $datatype->getNames(), true), 0);
    }

}
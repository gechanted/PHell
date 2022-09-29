<?php

namespace PHell\Code\DatatypeValidators;

use PHell\Flow\Datatypes\DatatypeInterface;

class FloatTypeValidator implements DatatypeValidatorInterface
{
    const TYPE_FLOAT = 'float';

    public function validate(DatatypeInterface $datatype): DatatypeValidation
    {
        if (in_array(self::TYPE_FLOAT, $datatype->getNames(), true)) {
            return new DatatypeValidation(true, 0);
        } else {
            return new DatatypeValidation(in_array(IntegerTypeValidator::TYPE_INTEGER, $datatype->getNames(), true), 1);
        }
    }
}
<?php

namespace PHell\Flow\Data\DatatypeValidators;

use PHell\Flow\Data\Datatypes\DatatypeInterface;

class StringTypeValidator implements DatatypeValidatorInterface
{

    const TYPE_STRING = 'string';

    public function validate(DatatypeInterface $datatype): DatatypeValidation
    {
        if (in_array(self::TYPE_STRING, $datatype->getNames(), true)) {
            return new DatatypeValidation(true, 0);
        } else  if (in_array(FloatTypeValidator::TYPE_FLOAT, $datatype->getNames(), true)) {
            return new DatatypeValidation(true, 1);
        } else  {
            return new DatatypeValidation(in_array(IntegerTypeValidator::TYPE_INTEGER, $datatype->getNames(), true), 1);
        }
    }

}
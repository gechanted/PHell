<?php

namespace PHell\Flow\Data\DatatypeValidators;

use PHell\Flow\Data\Datatypes\DatatypeInterface;

class IntegerTypeValidator implements DatatypeValidatorInterface
{
    const TYPE_INTEGER = 'integer';

    public function validate(DatatypeInterface $datatype): DatatypeValidation
    {
        return new DatatypeValidation(in_array(self::TYPE_INTEGER, $datatype->getNames(), true), 0);
    }
}
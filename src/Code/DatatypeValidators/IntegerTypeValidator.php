<?php

namespace PHell\Code\DatatypeValidators;

use PHell\Flow\Datatypes\DatatypeInterface;

class IntegerTypeValidator implements DatatypeValidatorInterface
{
    const TYPE_INTEGER = 'integer';

    public function validate(DatatypeInterface $datatype): DatatypeValidation
    {
        return new DatatypeValidation(in_array(self::TYPE_INTEGER, $datatype->getNames(), true), 0);
    }
}
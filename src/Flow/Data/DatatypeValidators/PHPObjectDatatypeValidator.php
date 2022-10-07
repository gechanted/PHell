<?php

namespace PHell\Flow\Data\DatatypeValidators;

use PHell\Flow\Data\Datatypes\DatatypeInterface;

class PHPObjectDatatypeValidator implements DatatypeValidatorInterface
{
    const PHP_OBJECT_TYPE = 'PhpObject';

    public function validate(DatatypeInterface $datatype): DatatypeValidation
    {
        return new DatatypeValidation(in_array(self::PHP_OBJECT_TYPE, $datatype->getNames(), true), 0);
    }
}
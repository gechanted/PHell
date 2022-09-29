<?php

namespace PHell\Code\DatatypeValidators;

use PHell\Flow\Datatypes\DatatypeInterface;

class PHPObjectDatatypeValidator implements DatatypeValidatorInterface
{
    const PHP_OBJECT_TYPE = 'PhpObject';

    public function validate(DatatypeInterface $datatype): DatatypeValidation
    {
        return new DatatypeValidation(in_array(self::PHP_OBJECT_TYPE, $datatype->getNames(), true), 0);
    }
}
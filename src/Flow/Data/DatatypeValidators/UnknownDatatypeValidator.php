<?php

namespace PHell\Flow\Data\DatatypeValidators;

use PHell\Flow\Data\Datatypes\DatatypeInterface;

class UnknownDatatypeValidator implements DatatypeValidatorInterface
{
    public function validate(DatatypeInterface $datatype): DatatypeValidation
    {
        return new DatatypeValidation(true,0);
    }
}
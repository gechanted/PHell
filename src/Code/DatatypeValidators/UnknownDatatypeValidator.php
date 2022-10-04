<?php

namespace PHell\Code\DatatypeValidators;

use PHell\Flow\Datatypes\DatatypeInterface;

class UnknownDatatypeValidator implements DatatypeValidatorInterface
{
    public function validate(DatatypeInterface $datatype): DatatypeValidation
    {
        return new DatatypeValidation(true,0);
    }
}
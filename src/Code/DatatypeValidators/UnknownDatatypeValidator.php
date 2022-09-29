<?php

namespace PHell\Code\DatatypeValidators;

class UnknownDatatypeValidator implements DatatypeValidatorInterface
{
    public function validate(DatatypeValidatorInterface $datatype): DatatypeValidation
    {
        return new DatatypeValidation(true,0);
    }
}
<?php

namespace PHell\Code\DatatypeValidators;

use PHell\Flow\Datatypes\DatatypeInterface;

interface DatatypeValidatorInterface
{
    public function validate(DatatypeInterface $datatype): DatatypeValidation;
}
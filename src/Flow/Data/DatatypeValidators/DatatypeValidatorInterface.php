<?php

namespace PHell\Flow\Data\DatatypeValidators;

use PHell\Flow\Data\Datatypes\DatatypeInterface;

interface DatatypeValidatorInterface
{
    public function validate(DatatypeInterface $datatype): DatatypeValidation;
}
<?php

namespace PHell\Flow\Functions;

use PHell\Flow\Data\DatatypeValidators\DatatypeValidatorInterface;

class ValidatorFunctionParenthesisParameter
{

    public function __construct(private readonly string $name, private readonly DatatypeValidatorInterface $datatype)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDatatype(): DatatypeValidatorInterface
    {
        return $this->datatype;
    }
}
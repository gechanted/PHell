<?php

namespace PHell\Flow\Functions;

use PHell\Code\DatatypeValidators\DatatypeValidatorInterface;

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
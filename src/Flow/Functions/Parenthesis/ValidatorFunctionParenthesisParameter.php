<?php

namespace PHell\Flow\Functions\Parenthesis;

use PHell\Flow\Data\DatatypeValidators\DatatypeValidatorInterface;
use PHell\Flow\Main\Statement;

class ValidatorFunctionParenthesisParameter
{

    public function __construct(private readonly string $name, private readonly DatatypeValidatorInterface $datatype, private readonly ?Statement $default = null)
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

    public function isOptional(): bool
    {
        return $this->default !== null;
    }

    public function getDefault(): ?Statement
    {
        return $this->default;
    }
}
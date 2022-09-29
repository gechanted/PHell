<?php

namespace PHell\Flow\Functions;

use PHell\Flow\Datatypes\DatatypeInterface;

class FunctionParenthesisParameter
{

    public function __construct(private readonly string $name, private readonly DatatypeInterface $datatype)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDatatype(): DatatypeInterface
    {
        return $this->datatype;
    }
}
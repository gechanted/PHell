<?php

namespace PHell\Flow\Functions\Parenthesis;

use PHell\Flow\Data\Data\DataInterface;

class FunctionParenthesisParameter
{

    public function __construct(private readonly string $name, private readonly DataInterface $datatype)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getData(): DataInterface
    {
        return $this->datatype;
    }
}
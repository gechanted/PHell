<?php

namespace PHell\Flow\Functions\Parenthesis;

use PHell\Flow\Data\Data\DataInterface;

class FunctionParenthesisParameter
{

    public function __construct(private readonly DataInterface $datatype)
    {
    }

    public function getData(): DataInterface
    {
        return $this->datatype;
    }
}
<?php

namespace PHell\Flow\Functions\Parenthesis;

use PHell\Flow\Data\Data\DataInterface;

class NamedDataFunctionParenthesisParameter extends DataFunctionParenthesisParameter
{

    public function __construct(private readonly string $name, DataInterface $data)
    {
        parent::__construct($data);
    }

    public function getName(): string
    {
        return $this->name;
    }
}
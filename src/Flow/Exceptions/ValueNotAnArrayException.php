<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Datatypes\ArrayType;

class ValueNotAnArrayException extends OperatorInvalidInputException
{

    public function __construct(private readonly DataInterface $input)
    {
        parent::__construct('ValueNotAnArrayException', 'ArrayOperator', [new ArrayType()], [$this->input]);
        $this->setObjectOuterVar('value', $this->input);
    }
}
<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Datatypes\ArrayType;

class ValueNotAnArrayException extends OperatorInvalidInputException
{

    public function __construct(private readonly DataInterface $input)
    {
        parent::__construct('ValueNotAnArrayException', 'ArrayOperator', [ArrayType::TYPE_ARRAY], [$this->input->getNames()[0]]);
        $this->setObjectOuterVar('value', $this->input);
    }
}
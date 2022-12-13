<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Datatypes\IntegerType;
use PHell\Flow\Data\Datatypes\StringType;

class ValueNotAnIndexException extends OperatorInvalidInputException
{

    public function __construct(private readonly DataInterface $input)
    {
        parent::__construct('ValueNotAnIndexException', 'ArrayOperator', [new StringType(), new IntegerType()], [$this->input]);
        $this->setObjectOuterVar('value', $this->input);
    }

}
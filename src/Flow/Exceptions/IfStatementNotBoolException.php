<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Datatypes\BooleanType;

class IfStatementNotBoolException extends OperatorInvalidInputException
{

    public function __construct(DataInterface $input)
    {
        parent::__construct('IfStatementNotBoolException', 'If', [new BooleanType()], [$input]);
    }
}
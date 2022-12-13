<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Datatypes\BooleanType;

class LoopStatementNotBoolException extends OperatorInvalidInputException
{

    public function __construct(private readonly DataInterface $input)
    {
        parent::__construct('DoWhileStatementNotBoolException', 'DoWhile', [new BooleanType()], [$this->input]);
        $this->setObjectOuterVar('value', $this->input);
    }
}
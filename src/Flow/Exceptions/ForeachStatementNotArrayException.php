<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Datatypes\ArrayType;

class ForeachStatementNotArrayException extends OperatorInvalidInputException
{

    public function __construct(private readonly DataInterface $input)
    {
        parent::__construct('ForeachStatementNotArrayException', 'Foreach', [new ArrayType()], [$this->input]);
        $this->setObjectOuterVar('value', $this->input);
    }

}
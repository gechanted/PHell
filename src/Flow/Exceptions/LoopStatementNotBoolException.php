<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Data\Data\DataInterface;

class LoopStatementNotBoolException extends OperatorInvalidInputException
{

    public function __construct(private readonly DataInterface $input)
    {
        parent::__construct('DoWhileStatementNotBoolException', 'DoWhile', ['bool'], [$this->input->getNames()[0]]);
        $this->setObjectOuterVar('value', $this->input);
    }
}
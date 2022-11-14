<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Data\Data\DataInterface;

class ForeachStatementNotArrayException extends OperatorInvalidInputException
{

    public function __construct(private readonly DataInterface $input)
    {
        parent::__construct('ForeachStatementNotArrayException', 'Foreach', ['array'], [$this->input->getNames()[0]]);
        $this->setObjectOuterVar('value', $this->input);
    }

}
<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Datatypes\IntegerType;

class ContinueException extends OperatorInvalidInputException
{

    public function __construct(DataInterface $input)
    {
        parent::__construct('BreakException', 'break', [new IntegerType()], [$input]);
    }
}
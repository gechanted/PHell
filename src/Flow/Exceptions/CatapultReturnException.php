<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Datatypes\RunningFunctionDatatype;
use PHell\Flow\Data\Datatypes\UnknownDatatype;

class CatapultReturnException extends OperatorInvalidInputException
{

    public function __construct(DataInterface $input)
    {
        parent::__construct('CatapultReturnException',
            'catapult-return',
            [new RunningFunctionDatatype(new UnknownDatatype())],
            [$input]);
    }
}
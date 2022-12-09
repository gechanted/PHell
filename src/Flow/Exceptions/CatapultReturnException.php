<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Data\Datatypes\RunningFunctionDatatype;

class CatapultReturnException extends OperatorInvalidInputException
{

    public function __construct(string $input)
    {
        parent::__construct('CatapultReturnException',
            'catapult-return',
            [RunningFunctionDatatype::TYPE_RUNNINGFUNCTION],
            [$input]);
    }
}
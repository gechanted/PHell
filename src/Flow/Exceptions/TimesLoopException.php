<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Datatypes\IntegerType;

class TimesLoopException extends OperatorInvalidInputException
{

    public function __construct(DataInterface $input)
    {
        parent::__construct('TimesLoopException', 'TimesLoop', [IntegerType::TYPE_INTEGER], [$input]);
    }
}
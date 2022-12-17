<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Datatypes\BooleanType;

class InvertException extends OperatorInvalidInputException
{

    /**
     * @param DataInterface[] $input
     */
    public function __construct(array $input)
    {
        parent::__construct('InvertException', 'Invert (!)',
            [new BooleanType()], $input);
    }
}
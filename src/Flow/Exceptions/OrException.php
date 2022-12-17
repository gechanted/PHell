<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Datatypes\BooleanType;

class OrException extends OperatorInvalidInputException
{

    /**
     * @param DataInterface[] $input
     */
    public function __construct(array $input)
    {
        parent::__construct('OrException', 'Or (||)',
            [new BooleanType()], $input);
    }
}
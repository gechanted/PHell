<?php

namespace PHell\Flow\Exceptions;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Datatypes\FloatType;
use PHell\Flow\Data\Datatypes\IntegerType;
use PHell\Flow\Data\Datatypes\StringType;

class MinusException extends OperatorInvalidInputException
{

    /**
     * @param DataInterface[] $input
     */
    public function __construct(array $input)
    {
        parent::__construct('MinusException', 'Minus (-)',
            [new FloatType(), new IntegerType()], $input);
    }
}
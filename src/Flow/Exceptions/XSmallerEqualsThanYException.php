<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Datatypes\FloatType;
use PHell\Flow\Data\Datatypes\IntegerType;

class XSmallerEqualsThanYException extends OperatorInvalidInputException
{

    /**
     * @param DataInterface[] $input
     */
    public function __construct(array $input)
    {
        parent::__construct('XSmallerEqualsThanYException', 'SmallerThan (<=)',
            [new FloatType(), new IntegerType()], $input);
    }
}
<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Datatypes\FloatType;
use PHell\Flow\Data\Datatypes\IntegerType;

class XBiggerEqualsThanYException extends OperatorInvalidInputException
{

    /**
     * @param DataInterface[] $input
     */
    public function __construct(array $input)
    {
        parent::__construct('XBiggerEqualsThanYException', 'BiggerEqualsThan (>=)',
            [new FloatType(), new IntegerType()], $input);
    }
}
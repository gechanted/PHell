<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Datatypes\PHellObjectDatatype;

class CallOnNotObjectException extends OperatorInvalidInputException
{
    public function __construct(DataInterface $input)
    {
        parent::__construct('CallOnNotObjectException', 'on', [new PHellObjectDatatype(null)], [$input]);
    }

}
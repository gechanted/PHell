<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Datatypes\PHellObjectDatatype;

class ExtendOnNotObjectException extends OperatorInvalidInputException
{
    public function __construct(DataInterface $input)
    {
        parent::__construct('ExtendOnNotObjectException', 'extend', [PHellObjectDatatype::TYPE_OBJECT], [$input->dumpValue()]);
    }
}
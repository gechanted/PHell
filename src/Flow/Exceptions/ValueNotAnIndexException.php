<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Datatypes\IntegerType;
use PHell\Flow\Data\Datatypes\StringType;

class ValueNotAnIndexException extends OperatorInvalidInputException
{

    public function __construct(private readonly DataInterface $input)
    {
        parent::__construct('ValueNotAnIndexException', 'ArrayOperator', [StringType::TYPE_STRING, IntegerType::TYPE_INTEGER], [$this->input->getNames()[0]]);
        $this->setObjectOuterVar('value', $this->input);
    }

}
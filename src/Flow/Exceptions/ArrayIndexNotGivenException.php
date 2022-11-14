<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\DatatypeValidators\IntegerTypeValidator;
use PHell\Flow\Data\DatatypeValidators\StringTypeValidator;

class ArrayIndexNotGivenException extends OperatorInvalidInputException
{

    public function __construct(private readonly DataInterface $input)
    {
        parent::__construct('ArrayIndexNotGivenException', 'ArrayOperator', [StringTypeValidator::TYPE_STRING, IntegerTypeValidator::TYPE_INTEGER], [$this->input->getNames()[0]]);
        $this->setObjectOuterVar('value', $this->input);
    }
}
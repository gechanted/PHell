<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\DatatypeValidators\ArrayTypeValidator;

class ValueNotAnArrayException extends OperatorInvalidInputException
{

    public function __construct(private readonly DataInterface $input)
    {
        parent::__construct('ValueNotAnArrayException', 'ArrayOperator', [ArrayTypeValidator::TYPE_ARRAY], [$this->input->getNames()[0]]);
        $this->setObjectOuterVar('value', $this->input);
    }
}
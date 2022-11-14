<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Datatypes\DatatypeInterface;

class ArrayTypeNotMatchedException extends OperatorInvalidInputException
{

    public function __construct(private readonly DataInterface $input, private readonly DataTypeInterface $type)
    {
        parent::__construct('ArrayTypeNotMatchedException', 'ArrayOperator', $this->type->getNames(), [$this->input->getNames()[0]]);
        $this->setObjectOuterVar('value', $this->input);
    }


}
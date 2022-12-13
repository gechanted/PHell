<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Data\UnexecutedFunctionCollection;
use PHell\Flow\Data\Datatypes\UnexecutedFunctionCollectionType;

class ValueNotALambdaFunctionCollectionException extends OperatorInvalidInputException
{

    public function __construct(private readonly DataInterface $input)
    {
        parent::__construct('ValueNotALambdaFunctionCollectionException', 'ExecuteFunctionOperator', [new UnexecutedFunctionCollectionType()], [$this->input]);
        $this->setObjectOuterVar('value', $this->input);
    }

}
<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Data\UnexecutedFunctionCollection;

class ValueNotALambdaFunctionCollectionException extends OperatorInvalidInputException
{

    public function __construct(private readonly DataInterface $input)
    {
        parent::__construct('ValueNotALambdaFunctionCollectionException', 'ExecuteFunctionOperator', [UnexecutedFunctionCollection::TYPE_LAMBDA], [$this->input->getNames()[0]]);
        $this->setObjectOuterVar('value', $this->input);
    }

}
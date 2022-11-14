<?php

namespace PHell\Flow\Exceptions;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Data\DataInterface;

class PlusException extends OperatorInvalidInputException
{

    /**
     * @param DataInterface[] $input
     */
    public function __construct(array $input)
    {
        $inputTypeNames = [];
        foreach ($input as $dataInterface) {
            $typeNames = $dataInterface->getNames();
            if (count($typeNames) === 0) {//if array empty => throw because everything should have a type
                throw new ShouldntHappenException();
            }
            $inputTypeNames[] = $typeNames[0];
        }
        parent::__construct('PlusException', 'Plus (+)', ['string', 'float', 'int'], $inputTypeNames, []);
    }
}
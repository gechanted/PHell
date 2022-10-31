<?php

namespace PHell\Flow\Exceptions;

class OperatorInvalidInputException extends DataTypeMismatchException
{

    /**
     * @param string $name
     * @param string $operatorName
     * @param string[] $validTypes
     * @param string[] $input
     * @param string[] $parentNames
     */
    public function __construct(string $name, string $operatorName, array $validTypes, array $input, array $parentNames = [])
    {
        $parentNames[] = 'OperatorInvalidInputException';
        $msg = 'Operator "'.$operatorName.'" can only handle '.implode(',',$validTypes).'.'.PHP_EOL.
            implode(',', $input).' given in.';
        parent::__construct($name, $msg, $parentNames);
    }
}
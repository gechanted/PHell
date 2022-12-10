<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Datatypes\DatatypeInterface;
use PHell\Flow\Functions\StandardFunctions\Dump;

class OperatorInvalidInputException extends DataTypeMismatchException
{

    /**
     * @param string $name
     * @param string $operatorName
     * @param DatatypeInterface[] $validTypes
     * @param DataInterface[] $input
     * @param string[] $parentNames
     */
    public function __construct(string $name, string $operatorName, array $validTypes, array $input, array $parentNames = [])
    {
        $inputString = [];
        foreach ($input as $inputData) {
            $inputString[] = Dump::dump($inputData);
        }
        $parentNames[] = 'OperatorInvalidInputException';
        $msg = 'Operator "'.$operatorName.'" can only handle '.implode(',',$validTypes).'.'.PHP_EOL.
            '['.implode(',', $inputString).'] given in.';
        parent::__construct($name, $msg, $parentNames);
    }
}
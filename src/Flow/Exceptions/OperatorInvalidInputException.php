<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Data\Data\Arra;
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
        $validTypeString = [];
        foreach ($validTypes as $type) {
            $inputString[] = $type->dumpType();
        }
        $parentNames[] = 'OperatorInvalidInputException';
        $msg = 'Operator "'.$operatorName.'" can only handle '.implode(',',$validTypeString).'.'.PHP_EOL.
            '['.implode(',', $inputString).'] given in.';
        parent::__construct($name, $msg, $parentNames);
        if (count($input) === 1) {
            foreach ($input as $data) {
                $this->setNormalVar('input', $data);
            }
        } else {
            $array = new Arra($input);
            $this->setNormalVar('input', $array);
        }
    }
}
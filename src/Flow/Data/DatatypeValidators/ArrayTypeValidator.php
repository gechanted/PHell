<?php

namespace PHell\Flow\Data\DatatypeValidators;

use PHell\Flow\Data\Datatypes\ArrayType;
use PHell\Flow\Data\Datatypes\DatatypeInterface;

class ArrayTypeValidator implements DatatypeValidatorInterface
{
    const TYPE_ARRAY = 'array';

    public function __construct(protected readonly ?DatatypeValidatorInterface $datatypeValidator = null)
    {
    }

    public function validate(DatatypeInterface $datatype): DatatypeValidation
    {
        $result = false;
        $depth = 0;
        if ( in_array(self::TYPE_ARRAY, $datatype->getNames(), true) ) {
            $result = true;
            if ($this->datatypeValidator !== null) {  //requires check
                if ($datatype instanceof ArrayType) { //is checkable

                    return $this->datatypeValidator->validate($datatype->getType());
                }
            }
        }
        return new DatatypeValidation($result, $depth);
    }
}
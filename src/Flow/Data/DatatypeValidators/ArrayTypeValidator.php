<?php

namespace PHell\Flow\Data\DatatypeValidators;

use PHell\Flow\Data\Datatypes\ArrayType;
use PHell\Flow\Data\Datatypes\DatatypeInterface;

class ArrayTypeValidator implements DatatypeValidatorInterface
{
    const TYPE_ARRAY = 'array';

    public function __construct(protected readonly ?string $type = null)
    {
    }

    public function validate(DatatypeInterface $datatype): DatatypeValidation
    {
        $result = false;
        $depth = 0;
        if ( in_array(self::TYPE_ARRAY, $datatype->getNames(), true) ) {
            $result = true;
            if ($this->getType() !== null) {  //requires check
                if ($datatype instanceof ArrayType) { //is checkable

                    if ($this->getType() !== $datatype->getType()) { //if simple check doesnt go well
                        //check every subitem
                        //add depth?
                        //TODO do
                    }
                }
            }
        }
        return new DatatypeValidation($result, $depth);
    }

    public function getType(): ?string
    {
        return $this->type;
    }
}
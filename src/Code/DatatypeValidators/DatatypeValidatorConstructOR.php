<?php

namespace PHell\Code\DatatypeValidators;

use PHell\Flow\Datatypes\DatatypeInterface;

class DatatypeValidatorConstructOR implements DatatypeValidatorInterface
{

    /**
     * @param DatatypeValidatorInterface[] $datatypes
     */
    public function __construct(private readonly array $datatypes)
    {
    }

    public function validate(DatatypeInterface $datatype): DatatypeValidation
    {
        $best = null;
        foreach ($this->datatypes as $type) {
            $result = $type->validate($datatype);
            if ($result->isSuccess()) {

                if ($best === null) {
                    $best = $result;
                } elseif ($best->getDepth() > $result->getDepth()) {
                    $best = $result;
                }

            }
        }

        if ($best === null) {
            return new DatatypeValidation(false, 0);
        }
        return $best;
    }
}
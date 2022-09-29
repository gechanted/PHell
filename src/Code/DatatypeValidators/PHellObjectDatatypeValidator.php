<?php

namespace PHell\Code\DatatypeValidators;

use PHell\Flow\Datatypes\DatatypeInterface;

class PHellObjectDatatypeValidator implements DatatypeValidatorInterface
{

    public function __construct(private readonly string $name)
    {
    }

    public function validate(DatatypeInterface $datatype): DatatypeValidation
    {
        $counter = 0;
        foreach ($datatype->getNames() as $name) {
            if ($name === $this->name) {
                return new DatatypeValidation(true, $counter);
            }
            $counter++;
        }
        return new DatatypeValidation(false, 0);
    }
}
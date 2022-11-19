<?php

namespace PHell\Flow\Data\Datatypes;

class UnknownDatatype extends AbstractType implements DatatypeInterface
{
    public function validate(DatatypeInterface $datatype): DatatypeValidation
    {
        return new DatatypeValidation(true,0);
    }

    public function getNames(): array
    {
        return ['unknown'];
    }

    public function dumpType(): string
    {
        return 'unknown';
    }


    public function realValidate(DatatypeInterface $datatype): DatatypeValidation
    {
        return new DatatypeValidation(true, 0);
    }
}
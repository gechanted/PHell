<?php

namespace PHell\Flow\Data\Datatypes;

class UnknownDatatype extends AbstractType implements DatatypeInterface
{

    const TYPE_UNKNOWN = 'unknown';

    public function validate(DatatypeInterface $datatype): DatatypeValidation
    {
        return new DatatypeValidation(true,0);
    }

    public function getNames(): array
    {
        return [self::TYPE_UNKNOWN];
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
<?php

namespace PHell\Flow\Data\Datatypes;

class IntegerType extends AbstractType implements DatatypeInterface
{
    const TYPE_INTEGER = 'integer';

    public function getNames(): array
    {
        return [self::TYPE_INTEGER];
    }

    public function dumpType(): string
    {
        return 'int';
    }

    public function realValidate(DatatypeInterface $datatype): DatatypeValidation
    {
        return new DatatypeValidation(in_array(self::TYPE_INTEGER, $datatype->getNames(), true), 0);
    }
}
<?php

namespace PHell\Flow\Data\Datatypes;

class BooleanType extends AbstractType implements DatatypeInterface
{
    const TYPE_BOOLEAN = 'boolean';

    public function getNames(): array
    {
        return [self::TYPE_BOOLEAN];
    }

    public function realValidate(DatatypeInterface $datatype): DatatypeValidation
    {
        return new DatatypeValidation(in_array(self::TYPE_BOOLEAN, $datatype->getNames(), true), 0);
    }

    public function dumpType(): string
    {
        return 'boolean';
    }
}
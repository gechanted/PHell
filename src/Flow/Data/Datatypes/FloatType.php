<?php

namespace PHell\Flow\Data\Datatypes;

class FloatType extends AbstractType implements DatatypeInterface
{
    const TYPE_FLOAT = 'float';

    public function getNames(): array
    {
        return [self::TYPE_FLOAT];
    }

    public function dumpType(): string
    {
        return 'float';
    }

    public function realValidate(DatatypeInterface $datatype): DatatypeValidation
    {
        if (in_array(self::TYPE_FLOAT, $datatype->getNames(), true)) {
            return new DatatypeValidation(true, 0);
        } else {
            return new DatatypeValidation(in_array(IntegerType::TYPE_INTEGER, $datatype->getNames(), true), 1);
        }
    }
}
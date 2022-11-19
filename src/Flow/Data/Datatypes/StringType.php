<?php

namespace PHell\Flow\Data\Datatypes;


class StringType extends AbstractType implements DatatypeInterface
{
    const TYPE_STRING = 'string';

    public function getNames(): array
    {
        return [self::TYPE_STRING];
    }

    public function dumpType(): string
    {
        return 'string';
    }

    public function realValidate(DatatypeInterface $datatype): DatatypeValidation
    {
        if (in_array(self::TYPE_STRING, $datatype->getNames(), true)) {
            return new DatatypeValidation(true, 0);
        } else  if (in_array(FloatType::TYPE_FLOAT, $datatype->getNames(), true)) {
            return new DatatypeValidation(true, 1);
        } else  {
            return new DatatypeValidation(in_array(IntegerType::TYPE_INTEGER, $datatype->getNames(), true), 1);
        }
    }

}
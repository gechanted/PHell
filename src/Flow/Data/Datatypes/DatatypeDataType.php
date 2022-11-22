<?php

namespace PHell\Flow\Data\Datatypes;

class DatatypeDataType extends AbstractType
{

    const TYPE_DATATYPE = 'datatype';

    public function getNames(): array
    {
        return [self::TYPE_DATATYPE];
    }

    public function dumpType(): string
    {
        return self::TYPE_DATATYPE;
    }

    public function realValidate(DatatypeInterface $datatype): DatatypeValidation
    {
        return new DatatypeValidation(in_array(self::TYPE_DATATYPE, $datatype->getNames(), true), 0);
    }
}
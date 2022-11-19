<?php

namespace PHell\Flow\Data\Datatypes;


class PHPObjectDatatype extends AbstractType implements DatatypeInterface
{
    const PHP_OBJECT_TYPE = 'PhpObject';

    public function getNames(): array
    {
        return [self::PHP_OBJECT_TYPE];
    }

    public function dumpType(): string
    {
        return 'PHPObject';
    }

    public function realValidate(DatatypeInterface $datatype): DatatypeValidation
    {
        return new DatatypeValidation(in_array(self::PHP_OBJECT_TYPE, $datatype->getNames(), true), 0);
    }
}
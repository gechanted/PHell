<?php

namespace PHell\Flow\Data\Datatypes;

use PHell\Flow\Data\Data\Nil;

class UndefinedType extends AbstractType
{

    public const TYPE_UNDEFINED = 'undefined';

    /** @return string[] */
    public function getNames(): array
    {
        return [self::TYPE_UNDEFINED, Nil::TYPE_NULL];
    }

    public function realValidate(DatatypeInterface $datatype): DatatypeValidation
    {
        return new DatatypeValidation(in_array(self::TYPE_UNDEFINED, $datatype->getNames(), true), 0);
    }

    public function dumpType(): string
    {
        return self::TYPE_UNDEFINED;
    }
}
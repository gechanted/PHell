<?php

namespace PHell\Flow\Data\Datatypes;

use PHell\Flow\Data\Data\Nil;

class VoidType extends AbstractType
{

    public const TYPE_VOID = 'void';

    /** @return string[] */
    public function getNames(): array
    {
        return [self::TYPE_VOID, Nil::TYPE_NULL];
    }

    public function realValidate(DatatypeInterface $datatype): DatatypeValidation
    {
        return new DatatypeValidation(in_array(self::TYPE_VOID, $datatype->getNames(), true), 0);
    }

    public function dumpType(): string
    {
        return self::TYPE_VOID;
    }
}
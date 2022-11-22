<?php

namespace PHell\Flow\Data\Datatypes;

class UnexecutedFunctionCollectionType extends AbstractType
{

    public const TYPE_LAMBDA = 'lambda';

    public function getNames(): array
    {
        return [self::TYPE_LAMBDA];
    }

    public function realValidate(DatatypeInterface $datatype): DatatypeValidation
    {
        return new DatatypeValidation(in_array(self::TYPE_LAMBDA, $datatype->getNames(), true), 0);
    }

    public function dumpType(): string
    {
        return self::TYPE_LAMBDA;
    }
}
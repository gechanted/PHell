<?php

namespace PHell\Flow\Data\Datatypes;

class ResourceType extends AbstractType
{
    public const TYPE_RESOURCE = 'resource';

    public function getNames(): array
    {
        return [self::TYPE_RESOURCE];
    }

    public function realValidate(DatatypeInterface $datatype): DatatypeValidation
    {
        return new DatatypeValidation(in_array(self::TYPE_RESOURCE, $datatype->getNames(), true), 0);
    }

    public function dumpType(): string
    {
        return self::TYPE_RESOURCE;
    }
}
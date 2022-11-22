<?php

namespace PHell\Flow\Data\Datatypes;

class ClosedResourceType extends AbstractType implements DatatypeInterface
{

    public const TYPE_CLOSED_RESOURCE = 'closed resource';

    public function getNames(): array
    {
        return [self::TYPE_CLOSED_RESOURCE];
    }

    public function dumpType(): string
    {
        return self::TYPE_CLOSED_RESOURCE;
    }

    public function realValidate(DatatypeInterface $datatype): DatatypeValidation
    {
        return new DatatypeValidation(in_array(self::TYPE_CLOSED_RESOURCE, $datatype->getNames(), true), 0);
    }
}
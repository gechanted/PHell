<?php

namespace PHell\Flow\Data\Datatypes;

class NullType extends AbstractType
{

    public const TYPE_NULL = 'null';

    /** @return string[] */
    public function getNames(): array
    {
        return [self::TYPE_NULL];
    }

    public function realValidate(DatatypeInterface $datatype): DatatypeValidation
    {
        $counter = 0;
        foreach ($datatype->getNames() as $typeName) {
            if ($typeName === self::TYPE_NULL){
                return new DatatypeValidation(true, $counter);
            }
            $counter++;
        }
        return new DatatypeValidation(false, 0);
    }

    public function dumpType(): string
    {
        return self::TYPE_NULL;
    }
}
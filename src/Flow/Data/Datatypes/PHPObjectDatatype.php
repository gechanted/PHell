<?php

namespace PHell\Flow\Data\Datatypes;

use PHell\Flow\Functions\PHPObject;

/**
 * @see PHPObject
 * !!! EVERYTHING IN HERE SHOULD BE DUPLICATED AND MATCHING WITH PHPObject !!!
 */
class PHPObjectDatatype extends AbstractType implements DatatypeInterface
{
    const PHP_OBJECT_TYPE = 'PhpObject';

    public function __construct(string $name) //TODO DO
    {
    }

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
        //TODO + check if Data is also PHPObject + classname + parents
        //TODO copy everything to PHPObject
    }
}
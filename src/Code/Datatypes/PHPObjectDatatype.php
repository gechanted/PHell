<?php

namespace PHell\Code\Datatypes;

class PHPObjectDatatype implements DatatypeInterface
{

    const PHP_OBJECT_TYPE = 'PhpObject';

    public function validate(DatatypeInterface $datatype)
    {
        // TODO: Implement validate() method.
    }

    public function getNames(): array
    {
        return [self::PHP_OBJECT_TYPE];
    }
}
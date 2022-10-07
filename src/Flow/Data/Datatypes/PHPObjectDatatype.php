<?php

namespace PHell\Flow\Data\Datatypes;

use PHell\Flow\Data\DatatypeValidators\PHPObjectDatatypeValidator;

class PHPObjectDatatype extends PHPObjectDatatypeValidator implements DatatypeInterface
{
    public function getNames(): array
    {
        return [self::PHP_OBJECT_TYPE];
    }
}
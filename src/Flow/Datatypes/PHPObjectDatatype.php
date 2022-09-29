<?php

namespace PHell\Flow\Datatypes;

use PHell\Code\DatatypeValidators\PHPObjectDatatypeValidator;

class PHPObjectDatatype extends PHPObjectDatatypeValidator implements DatatypeInterface
{
    public function getNames(): array
    {
        return [self::PHP_OBJECT_TYPE];
    }
}
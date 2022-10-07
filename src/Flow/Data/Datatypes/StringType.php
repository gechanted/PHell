<?php

namespace PHell\Flow\Data\Datatypes;

use PHell\Flow\Data\DatatypeValidators\StringTypeValidator;

class StringType extends StringTypeValidator implements DatatypeInterface
{
    public function getNames(): array
    {
        return [self::TYPE_STRING];
    }
}
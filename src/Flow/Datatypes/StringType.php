<?php

namespace PHell\Flow\Datatypes;

use PHell\Code\DatatypeValidators\StringTypeValidator;

class StringType extends StringTypeValidator implements DatatypeInterface
{
    public function getNames(): array
    {
        return [self::TYPE_STRING];
    }
}
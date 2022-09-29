<?php

namespace PHell\Flow\Datatypes;

use PHell\Code\DatatypeValidators\FloatTypeValidator;

class FloatType extends FloatTypeValidator implements DatatypeInterface
{
    public function getNames(): array
    {
        return [self::TYPE_FLOAT];
    }
}
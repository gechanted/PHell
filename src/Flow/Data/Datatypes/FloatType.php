<?php

namespace PHell\Flow\Data\Datatypes;

use PHell\Flow\Data\DatatypeValidators\FloatTypeValidator;

class FloatType extends FloatTypeValidator implements DatatypeInterface
{
    public function getNames(): array
    {
        return [self::TYPE_FLOAT];
    }
}
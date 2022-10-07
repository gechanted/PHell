<?php

namespace PHell\Flow\Data\Datatypes;

use PHell\Flow\Data\DatatypeValidators\IntegerTypeValidator;

class IntegerType extends IntegerTypeValidator implements DatatypeInterface
{

    public function getNames(): array
    {
        return [self::TYPE_INTEGER];
    }
}
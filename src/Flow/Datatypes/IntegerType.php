<?php

namespace PHell\Flow\Datatypes;

use PHell\Code\DatatypeValidators\IntegerTypeValidator;

class IntegerType extends IntegerTypeValidator implements DatatypeInterface
{

    public function getNames(): array
    {
        return [self::TYPE_INTEGER];
    }
}
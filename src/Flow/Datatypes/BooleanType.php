<?php

namespace PHell\Flow\Datatypes;

use PHell\Code\DatatypeValidators\BooleanTypeValidator;

class BooleanType extends BooleanTypeValidator implements DatatypeInterface
{
    public function getNames(): array
    {
        return [self::TYPE_BOOLEAN];
    }

}
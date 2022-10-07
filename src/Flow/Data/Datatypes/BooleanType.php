<?php

namespace PHell\Flow\Data\Datatypes;

use PHell\Flow\Data\DatatypeValidators\BooleanTypeValidator;

class BooleanType extends BooleanTypeValidator implements DatatypeInterface
{
    public function getNames(): array
    {
        return [self::TYPE_BOOLEAN];
    }

}
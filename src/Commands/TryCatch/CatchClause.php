<?php

namespace PHell\Commands\TryCatch;

use PHell\Flow\Data\DatatypeValidators\PHellObjectDatatype;
use Phell\Flow\Main\Code;

class CatchClause
{

    public function __construct(private readonly PHellObjectDatatype $objectValidator, private readonly Code $code)
    {
    }

    public function getObjectValidator(): PHellObjectDatatype
    {
        return $this->objectValidator;
    }

    public function getCode(): Code
    {
        return $this->code;
    }
}
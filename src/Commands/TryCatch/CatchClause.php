<?php

namespace PHell\Commands\TryCatch;

use PHell\Flow\Data\DatatypeValidators\PHellObjectDatatypeValidator;
use Phell\Flow\Main\Code;

class CatchClause
{

    public function __construct(private readonly PHellObjectDatatypeValidator $objectValidator, private readonly Code $code)
    {
    }

    public function getObjectValidator(): PHellObjectDatatypeValidator
    {
        return $this->objectValidator;
    }

    public function getCode(): Code
    {
        return $this->code;
    }
}
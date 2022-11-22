<?php

namespace PHell\Commands\TryCatch;

use PHell\Flow\Data\Datatypes\PHellObjectDatatype;
use Phell\Flow\Main\Code;
use PHell\Operators\Variable;

class CatchClause
{

    public function __construct(private readonly PHellObjectDatatype $objectValidator, private readonly Variable $variable, private readonly Code $code)
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

    public function getVariable(): Variable
    {
        return $this->variable;
    }
}
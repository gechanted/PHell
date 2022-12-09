<?php

namespace PHell\Flow\Exceptions;

class ContinueException extends OperatorInvalidInputException
{

    public function __construct(string $input)
    {
        parent::__construct('BreakException', 'break ', ['int'], [$input]);
    }
}
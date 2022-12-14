<?php

namespace PHell\Exceptions;

use PHell\Flow\Exceptions\AmbiguousOverloadFunctionCallException;

class PHellCallableResolveExceptionMultipleMatches extends PHellException
{

    public function __construct(private readonly AmbiguousOverloadFunctionCallException $exception)
    {
        parent::__construct($this->exception->getNormalVar('msg'));
    }

    public function getPHellException(): AmbiguousOverloadFunctionCallException
    {
        return $this->exception;
    }
}
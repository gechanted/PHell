<?php

namespace PHell\Exceptions;

use PHell\Flow\Exceptions\NoOverloadFunctionException;

class PHellCallableResolveExceptionNoMatches extends PHellException
{

    public function __construct(private readonly NoOverloadFunctionException $exception)
    {
        parent::__construct($this->exception->getNormalVar('msg'));
    }

    public function getPHellException(): NoOverloadFunctionException
    {
        return $this->exception;
    }
}
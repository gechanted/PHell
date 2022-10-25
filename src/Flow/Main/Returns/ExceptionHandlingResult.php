<?php

namespace PHell\Flow\Main\Returns;

use PHell\Commands\TryCatch\TryConstruct;

class ExceptionHandlingResult
{
    public function __construct(private readonly TryConstruct $handler)
    {
    }

    public function getHandler(): TryConstruct
    {
        return $this->handler;
    }
}
<?php

namespace PHell\Flow\Main\Returns;

use PHell\Commands\TryCatch\TryConstruct;

abstract class ExceptionHandlingResult
{
    public function __construct(private readonly object $handler)
    {
    }

    public function getHandler(): object
    {
        return $this->handler;
    }
}
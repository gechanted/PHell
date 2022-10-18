<?php

namespace PHell\Flow\Main;

class NoShoveExceptionHandlingResult extends ExceptionHandlingResult
{

    public function __construct()
    {
        parent::__construct(false, null);
    }
}
<?php

namespace PHell\Flow\Main;

class ExceptionHandlingResult
{

    public function __construct(private readonly bool $shallContinue, private $shoveBackValue)
    {
    }

    public function shallContinue(): bool
    {
        return $this->shallContinue;
    }

    public function getShoveBackValue()
    {
        return $this->shoveBackValue;
    }
}
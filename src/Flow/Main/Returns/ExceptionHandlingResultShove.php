<?php

namespace PHell\Flow\Main\Returns;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Main\ExceptionHandlingResult;

class ExceptionHandlingResultShove implements ExceptionHandlingResult
{

    public function __construct(private readonly DataInterface $shoveBackValue)
    {
    }

    public function shallContinue(): bool
    {
        return false;
    }

    public function getShoveBackValue()
    {
        return $this->shoveBackValue;
    }
}
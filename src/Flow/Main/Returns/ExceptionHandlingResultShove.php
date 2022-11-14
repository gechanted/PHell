<?php

namespace PHell\Flow\Main\Returns;

use PHell\Commands\TryCatch\TryConstruct;
use PHell\Flow\Data\Data\DataInterface;

class ExceptionHandlingResultShove extends ExceptionHandlingResult
{

    public function __construct(TryConstruct $handler, private readonly DataInterface $shoveBackValue)
    {
        parent::__construct($handler);
    }

    public function getShoveBackValue(): DataInterface
    {
        return $this->shoveBackValue;
    }
}
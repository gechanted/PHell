<?php

namespace PHell\Flow\Main\Returns;

use PHell\Constructs\TryCatch\TryConstruct;
use PHell\Flow\Data\Data\DataInterface;

class ExceptionHandlingResultShove extends ExceptionHandlingResult
{

    public function __construct(object $handler, private readonly DataInterface $shoveBackValue)
    {
        parent::__construct($handler);
    }

    public function getShoveBackValue(): DataInterface
    {
        return $this->shoveBackValue;
    }
}
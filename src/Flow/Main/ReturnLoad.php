<?php

namespace PHell\Flow\Main;

use PHell\Flow\Data\Data\DataInterface;

class ReturnLoad
{

    public function __construct(private readonly ?DataInterface $dataObject)
    {
    }

    public function isExceptionReturn(): bool
    {
        return $this->dataObject === null;
    }

    public function getData(): DataInterface
    {
        return $this->dataObject;
    }
}
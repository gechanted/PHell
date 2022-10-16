<?php

namespace PHell\Flow\Main;

class ReturnLoad
{

    public function __construct(private $dataObject)
    {
    }

    public function isExceptionReturn(): bool
    {
        return $this->dataObject === false;
    }

    public function getData()
    {
        return $this->dataObject;
    }
}
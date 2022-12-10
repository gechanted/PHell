<?php

namespace PHell\Flow\Data\Data;

use PHell\Flow\Data\Datatypes\ResourceType;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;

class Resource extends ResourceType implements DataInterface
{

    public function __construct(private $resource)
    {
    }

    public function v()
    {
        return $this->resource;
    }

    public function phpV()
    {
        return $this->v();
    }

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        return new DataReturnLoad($this);
    }

    public function dumpValue(): string
    {
        ob_start();
        var_dump($this->resource);
        $result = ob_get_clean();
        return self::TYPE_RESOURCE.'('. $result .')';
    }
}
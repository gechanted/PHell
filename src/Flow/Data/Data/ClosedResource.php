<?php

namespace PHell\Flow\Data\Data;

use PHell\Flow\Data\Datatypes\ClosedResourceType;
use PHell\Flow\Functions\FunctionObject;
use Phell\Flow\Main\CodeExceptionTransmitter;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;

class ClosedResource extends ClosedResourceType implements DataInterface
{

    public function __construct(private $resource)
    {
    }

    public function v()
    {
        return $this->resource;
    }

    public function getValue(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ReturnLoad
    {
        return new DataReturnLoad($this);
    }

    public function dumpValue(): string
    {
        ob_start();
        var_dump($this->resource);
        $result = ob_get_clean();
        return self::TYPE_CLOSED_RESOURCE.'('. $result .')';
    }
}
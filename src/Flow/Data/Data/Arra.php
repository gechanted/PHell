<?php

namespace PHell\Flow\Data\Data;

use PHell\Flow\Data\Datatypes\ArrayType;
use PHell\Flow\Data\Datatypes\DatatypeInterface;
use PHell\Flow\Functions\FunctionObject;
use Phell\Flow\Main\CodeExceptionTransmitter;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;

class Arra extends ArrayType implements DataInterface
{

    public function __construct(private readonly array $content, private readonly ?DatatypeInterface $type = null)
    {
        parent::__construct($type);
    }

    public function execute(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ExecutionResult
    {
        return new ExecutionResult();
    }

    public function v()
    {
        return $this->content;
    }

    public function assign(DataInterface $data, DataInterface $index)
    {
        $result = $this->type->validate($data);


        //TODO do
    }

    public function getValue(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ReturnLoad
    {
        return new DataReturnLoad($this);
    }
}
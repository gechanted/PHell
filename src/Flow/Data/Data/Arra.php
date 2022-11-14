<?php

namespace PHell\Flow\Data\Data;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Datatypes\ArrayType;
use PHell\Flow\Data\Datatypes\DatatypeInterface;
use PHell\Flow\Exceptions\ArrayTypeNotMatchedException;
use PHell\Flow\Functions\FunctionObject;
use Phell\Flow\Main\CodeExceptionTransmitter;
use Phell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExceptionHandlingResultNoShove;
use PHell\Flow\Main\Returns\ExceptionHandlingResultShove;
use Phell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;

class Arra extends ArrayType implements DataInterface
{

    public function __construct(private array $content, private readonly ?DatatypeInterface $type = null)
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

    public function assign(CodeExceptionTransmitter $upper, DataInterface $data, ?DataInterface $index = null): ReturnLoad
    {
        if ($this->type !== null) {
            if ($this->type->validate($data)->isSuccess() === false) {

                $exceptionResult = $upper->transmit(new ArrayTypeNotMatchedException($data, $this->type));
                if ($exceptionResult instanceof ExceptionHandlingResultNoShove) {
                    return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($exceptionResult->getHandler(), $exceptionResult->getExecutionResult())));
                }
                if ($exceptionResult instanceof ExceptionHandlingResultShove === false) {
                    throw new ShouldntHappenException();
                }
                $shoveValue = $exceptionResult->getShoveBackValue();
                if ($this->type->validate($shoveValue)->isSuccess()) {
                    $data = $shoveValue;
                } else {
                    return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($exceptionResult->getHandler(), new ExecutionResult())));
                }
            }
        }

        if ($index === null) {
            $this->content[] = $data;
        } else {
            $this->content[$index->v()] = $data;
        }

        return new DataReturnLoad($data);
    }

    public function getValue(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ReturnLoad
    {
        return new DataReturnLoad($this);
    }
}
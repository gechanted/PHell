<?php

namespace PHell\Flow\Data\Data;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Datatypes\ArrayType;
use PHell\Flow\Data\Datatypes\DatatypeInterface;
use PHell\Flow\Exceptions\ArrayTypeNotMatchedException;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExceptionHandlingResultNoShove;
use PHell\Flow\Main\Returns\ExceptionHandlingResultShove;
use PHell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;

class Arra extends ArrayType implements DataInterface
{

    /**
     * @param DataInterface[] $content
     * @param DatatypeInterface|null $type
     */
    public function __construct(private array $content, private readonly ?DatatypeInterface $type = null)
    {
        parent::__construct($type);
    }

    public function v()
    {
        return $this->content;
    }

    public function assign(CodeExceptionHandler $upper, DataInterface $data, ?DataInterface $index = null): ReturnLoad
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

        return $this->set($data, $index);
    }

    public function set(DataInterface $data, ?DataInterface $index = null): ReturnLoad
    {
        if ($index === null) {
            $this->content[] = $data;
        } else {
            $this->content[$index->v()] = $data;
        }

        return new DataReturnLoad($data);
    }

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        return new DataReturnLoad($this);
    }

    public function dumpValue(): string
    {
        $dump = '';
        foreach ($this->content as $key => $value) {
            $dump .= (is_int($key) ? $key : '"'.$key.'"').' => '.$value->dumpValue(). PHP_EOL;
        }
        return 'array<'.$this->type->dumpType().'>['.$dump.']';
    }
}
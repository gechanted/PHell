<?php

namespace PHell\Operators;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Data\Arra;
use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Datatypes\ArrayType;
use PHell\Flow\Data\Datatypes\IntegerType;
use PHell\Flow\Data\Datatypes\StringType;
use PHell\Flow\Exceptions\ArrayIndexNotGivenException;
use PHell\Flow\Exceptions\IndexDoesNotExistException;
use PHell\Flow\Exceptions\ValueNotAnArrayException;
use PHell\Flow\Exceptions\ValueNotAnIndexException;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use Phell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use Phell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;
use PHell\Flow\Main\Statement;

class ArrayOperator extends EasyStatement implements Assignable
{

    //TODO maybe add possibility to work on a string as an array of chars
    public function __construct(private readonly Statement $array, private readonly ?Statement $index = null)
    {
    }

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        $RL = $this->array->getValue($currentEnvironment, $exHandler);
        if ($RL instanceof DataReturnLoad === false) { return $RL; }

        $arrValidator = new ArrayType();
        $arrayValue = $RL->getData();
        if ($arrValidator->validate($arrayValue)->isSuccess() === false) {
            $exceptionResult = $exHandler->transmit(new ValueNotAnArrayException($arrayValue));
            return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($exceptionResult->getHandler(), new ExecutionResult())));
        }



        if ($this->index === null) {
            $exceptionResult = $exHandler->transmit(new ArrayIndexNotGivenException($arrayValue));
            return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($exceptionResult->getHandler(), new ExecutionResult())));
        }

        $RL = $this->index->getValue($currentEnvironment, $exHandler);
        if ($RL instanceof DataReturnLoad === false) { return $RL; }

        $stringValidator = new StringType();
        $intValidator = new IntegerType();
        $indexValue = $RL->getData();
        if ($stringValidator->validate($indexValue)->isSuccess() === false || $intValidator->validate($indexValue)->isSuccess() === false) {
            $exceptionResult = $exHandler->transmit(new ValueNotAnIndexException($indexValue));
            return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($exceptionResult->getHandler(), new ExecutionResult())));
        }

        if (array_key_exists($indexValue->v(), $arrayValue->v()) === false) {
            $exceptionResult = $exHandler->transmit(new IndexDoesNotExistException($indexValue));
            return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($exceptionResult->getHandler(), new ExecutionResult())));
        }

        return new DataReturnLoad($arrayValue->v()[$indexValue->v()]);
    }

    public function set(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler, ?DataInterface $value): ReturnLoad
    {
        $RL = $this->array->getValue($currentEnvironment, $exHandler);
        if ($RL instanceof DataReturnLoad === false) { return $RL; }

        $arrValidator = new ArrayType();
        $arrayValue = $RL->getData();
        if ($arrValidator->validate($arrayValue)->isSuccess() === false) {
            $exceptionResult = $exHandler->transmit(new ValueNotAnArrayException($arrayValue));
            return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($exceptionResult->getHandler(), new ExecutionResult())));
        }

        if ($arrayValue instanceof Arra === false) {
            throw new ShouldntHappenException();
        }


        if ($this->index === null) {
            $indexValue = null;
        } else {
            $RL = $this->index->getValue($currentEnvironment, $exHandler);
            if ($RL instanceof DataReturnLoad === false) { return $RL; }

            $stringValidator = new StringType();
            $intValidator = new IntegerType();
            $indexValue = $RL->getData();
            if ($stringValidator->validate($indexValue)->isSuccess() === false && $intValidator->validate($indexValue)->isSuccess() === false) {
                $exceptionResult = $exHandler->transmit(new ValueNotAnIndexException($indexValue));
                return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($exceptionResult->getHandler(), new ExecutionResult())));
            }
        }

        //TODO! check if this works

        return $arrayValue->assign($exHandler, $value, $indexValue);
    }
}
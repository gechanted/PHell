<?php

namespace PHell\Operators;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Data\UnexecutedFunctionCollection;
use PHell\Flow\Data\Datatypes\UnknownDatatype;
use PHell\Flow\Exceptions\ValueNotALambdaFunctionCollectionException;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\FunctionResolver;
use PHell\Flow\Functions\Parenthesis\FunctionParenthesis;
use PHell\Flow\Functions\Parenthesis\FunctionParenthesisParameter;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use Phell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use Phell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;
use PHell\Flow\Main\Statement;

class ExecuteFunction extends EasyStatement
{

    /** @param Statement[] $params */
    public function __construct(private readonly Statement $function, private readonly array $params)
    {
    }

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        $RL = $this->function->getValue($currentEnvironment, $exHandler);
        if ($RL instanceof ExceptionReturnLoad) { return $RL->getExecutionResult(); }
        if ($RL instanceof DataReturnLoad === false) { throw new ShouldntHappenException(); }

        $lambdaValidator = new UnexecutedFunctionCollection([]);
        $functionCollection = $RL->getData();
        if ($lambdaValidator->validate($functionCollection)->isSuccess() === false) {
            $exceptionResult = $exHandler->transmit(new ValueNotALambdaFunctionCollectionException($functionCollection));
            return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($exceptionResult->getHandler(), new ExecutionResult())));
        }


        $parenthesis = new FunctionParenthesis([], new UnknownDatatype());
        foreach ($this->params as $statement) {
            if ($statement instanceof Statement === false) { throw new ShouldntHappenException(); }
            $RL = $statement->getValue($currentEnvironment, $exHandler);
            if ($RL instanceof ExceptionReturnLoad) { return $RL->getExecutionResult(); }
            if ($RL instanceof DataReturnLoad === false) { throw new ShouldntHappenException(); }

            $parenthesis->addParameter(new FunctionParenthesisParameter($RL->getData()));
        }

        $lambdaOrReturnload = FunctionResolver::resolve($parenthesis, $functionCollection, $exHandler);
        if ($lambdaOrReturnload instanceof ReturnLoad) {
            return $lambdaOrReturnload;
        }
        $lambda = $lambdaOrReturnload;

        $runningFunction = $lambda->generateRunningFunction($parenthesis, $currentEnvironment->getObject());
        return $runningFunction->getValue($currentEnvironment, $exHandler);
    }
}
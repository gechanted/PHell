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

    protected function value(FunctionObject $currentEnvironment): ReturnLoad
    {
        $RL = $this->function->getValue($currentEnvironment, $this->upper);
        if ($RL instanceof ExceptionReturnLoad) { return $RL->getExecutionResult(); }
        if ($RL instanceof DataReturnLoad === false) { throw new ShouldntHappenException(); }

        $lambdaValidator = new UnexecutedFunctionCollection([]);
        $functionCollection = $RL->getData();
        if ($lambdaValidator->validate($functionCollection)->isSuccess() === false) {
            $exceptionResult = $this->upper->transmit(new ValueNotALambdaFunctionCollectionException($functionCollection));
            return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($exceptionResult->getHandler(), new ExecutionResult())));
        }


        $parenthesis = new FunctionParenthesis([], new UnknownDatatype());
        foreach ($this->params as $statement) {
            if ($statement instanceof Statement === false) { throw new ShouldntHappenException(); }
            $RL = $statement->getValue($currentEnvironment, $this->upper);
            if ($RL instanceof ExceptionReturnLoad) { return $RL->getExecutionResult(); }
            if ($RL instanceof DataReturnLoad === false) { throw new ShouldntHappenException(); }

            $parenthesis->addParameter(new FunctionParenthesisParameter($RL->getData()));
        }

        $lambdaOrReturnload = FunctionResolver::resolve($parenthesis, $functionCollection, $this->upper);
        if ($lambdaOrReturnload instanceof ReturnLoad) {
            return $lambdaOrReturnload;
        }
        $lambda = $lambdaOrReturnload;

        $runningFunction = $lambda->generateRunningFunction($parenthesis, $currentEnvironment);
        return $runningFunction->getValue($currentEnvironment, $this->upper);
    }
}
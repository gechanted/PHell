<?php

namespace PHell\Operators;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Data\UnexecutedFunctionCollection;
use PHell\Flow\Data\Datatypes\UnexecutedFunctionCollectionType;
use PHell\Flow\Data\Datatypes\UnknownDatatype;
use PHell\Flow\Exceptions\ValueNotALambdaFunctionCollectionException;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\FunctionResolver;
use PHell\Flow\Functions\Parenthesis\DataFunctionParenthesis;
use PHell\Flow\Functions\Parenthesis\DataFunctionParenthesisParameter;
use PHell\Flow\Functions\Parenthesis\NamedDataFunctionParenthesis;
use PHell\Flow\Functions\Parenthesis\NamedDataFunctionParenthesisParameter;
use PHell\Flow\Functions\Parenthesis\ValidatorFunctionParenthesis;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExceptionReturnLoad;
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
        if ($RL instanceof DataReturnLoad === false) { return $RL; }

        $lambdaValidator = new UnexecutedFunctionCollectionType();
        $functionCollection = $RL->getData();
        if ($lambdaValidator->validate($functionCollection)->isSuccess() === false && $functionCollection instanceof UnexecutedFunctionCollection === false) {
            $exceptionResult = $exHandler->handle(new ValueNotALambdaFunctionCollectionException($functionCollection));
            return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($exceptionResult->getHandler(), new ExecutionResult())));
        }


        $dataParenthesis = new DataFunctionParenthesis([], new UnknownDatatype());
        foreach ($this->params as $statement) {
            if ($statement instanceof Statement === false) { throw new ShouldntHappenException(); }
            $RL = $statement->getValue($currentEnvironment, $exHandler);
            if ($RL instanceof DataReturnLoad === false) { return $RL; }
            $dataParenthesis->addParameter(new DataFunctionParenthesisParameter($RL->getData()));
        }


        $lambdaOrReturnload = FunctionResolver::resolve($dataParenthesis, $functionCollection, $exHandler);
        if ($lambdaOrReturnload instanceof ReturnLoad) {
            return $lambdaOrReturnload;
        }
        $lambda = $lambdaOrReturnload;


        $parenthesisOrReturnload = ExecuteFunction::constructNamedDataFromValidatorAndDataFunctionParenthesis(
            $lambda->getParenthesis(), $dataParenthesis, $currentEnvironment, $exHandler );
        if ($parenthesisOrReturnload instanceof ReturnLoad) {
            return $parenthesisOrReturnload;
        }
        $parenthesis = $parenthesisOrReturnload;


        $runningFunction = $lambda->generateRunningFunction($parenthesis, $currentEnvironment->getObject(), $functionCollection->getDifferentOrigin());
        return $runningFunction->getValue($currentEnvironment, $exHandler);
    }

    public static function constructNamedDataFromValidatorAndDataFunctionParenthesis(
        ValidatorFunctionParenthesis $namedParenthesis,
        DataFunctionParenthesis $dataParenthesis,
        RunningFunction $currentEnvironment,
        CodeExceptionHandler $exHandler,
    ): NamedDataFunctionParenthesis|ReturnLoad
    {
        $names = $namedParenthesis->getParameters();
        $datas = $dataParenthesis->getParameters();

        $parameters = [];
        $count = count($names);
        for ($i = 0; $i < $count; $i++) {
            if (array_key_exists($i, $datas)) {
                $data = $datas[$i]->getData();
            } elseif ($names[$i]->isOptional()) {
                $rl = $names[$i]->getDefault()->getValue($currentEnvironment, $exHandler);
                if ($rl instanceof DataReturnLoad === false) { return $rl; }
                $data = $rl->getData();
            } else {
                throw new ShouldntHappenException();
            }
            $parameters[] = new NamedDataFunctionParenthesisParameter($names[$i]->getName(), $data);
        }

        return new NamedDataFunctionParenthesis($namedParenthesis->getReturnType(), $parameters);
    }
}
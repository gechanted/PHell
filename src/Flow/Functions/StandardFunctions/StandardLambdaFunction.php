<?php

namespace PHell\Flow\Functions\StandardFunctions;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\LambdaFunction;
use PHell\Flow\Functions\Parenthesis\DataFunctionParenthesis;
use PHell\Flow\Functions\Parenthesis\NamedDataFunctionParenthesis;
use PHell\Flow\Functions\Parenthesis\ValidatorFunctionParenthesis;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\Code;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;
use PHell\Flow\Main\Statement;
use PHell\Operators\ExecuteFunction;

abstract class StandardLambdaFunction extends LambdaFunction implements Statement
{

    //TODO maybe   from code quality perspective this should be two classes:
    // one, who implements the StandardLambda
    // and one who implements Statement
    // .
    // but I am lazy
    // (and it would just remove the if (null) {throw ShouldntHappenException} )

    /**
     * @see EasyStatement
     * should be same to EasyStatement->execute
     */
    public function execute(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ExecutionResult
    {
        $return = $this->getValue($currentEnvironment, $exHandler);
        return EasyStatement::returnLoadToExecutionResult($return);
    }

    public function __construct(string $name, private readonly ValidatorFunctionParenthesis $validatorParenthesis)
    {
        parent::__construct($name, null, $this->validatorParenthesis, new Code());
    }

    public function generateRunningFunction(DataFunctionParenthesis $parenthesis, FunctionObject $stack, ?FunctionObject $calledOn = null): Statement
    {
        $this->dataParenthesis = $parenthesis;
        $this->stack = $stack;
        return $this;
    }

    private DataFunctionParenthesis $dataParenthesis;
    private FunctionObject $stack;

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        if (isset($this->stack) === false || isset($this->dataParenthesis) === false) {
            throw new ShouldntHappenException();
        }
        $namedDataParenthesis = ExecuteFunction::constructNamedDataFromValidatorAndDataFunctionParenthesis(
            $this->validatorParenthesis, $this->dataParenthesis, $currentEnvironment, $exHandler);

        return $this->getReturnLoad($currentEnvironment, $exHandler, $namedDataParenthesis, $this->stack);
    }

    //TODO maybe find a better name: toooooo bad execute is already taken
    public abstract function getReturnLoad(
        RunningFunction $currentEnvironment,
        CodeExceptionHandler $exHandler,
        NamedDataFunctionParenthesis $parenthesis,
        FunctionObject $stack,
    ): ReturnLoad;
}
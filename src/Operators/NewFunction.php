<?php

namespace PHell\Operators;

use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\LambdaFunction;
use PHell\Flow\Functions\Parenthesis\ValidatorFunctionParenthesis;
use PHell\Flow\Main\Code;
use PHell\Flow\Main\EasyCommand;
use PHell\Flow\Main\Returns\ExecutionResult;

class NewFunction extends EasyCommand implements VisibilityAffected
{
    private string $visibility = FunctionObject::VISIBILITY_PRIVATE;

    public function __construct(
        private readonly string $name,
        private readonly ValidatorFunctionParenthesis $parenthesis,
        private readonly Code $code,
    ) { }

    public function changeVisibility(string $visibility)
    {
        $this->visibility = $visibility;
    }

    protected function exec(FunctionObject $currentEnvironment): ExecutionResult
    {
        $function = new LambdaFunction($this->name, $currentEnvironment, $this->parenthesis, $this->code);
        switch ($this->visibility) {
            case FunctionObject::VISIBILITY_PUBLIC:
                $currentEnvironment->addPublicFunction($function);
                break;
            case FunctionObject::VISIBILITY_PROTECTED:
                $currentEnvironment->addProtectedFunction($function);
                break;
            default:
                $currentEnvironment->addPrivateFunction($function);
        }

        return new ExecutionResult();
    }
}
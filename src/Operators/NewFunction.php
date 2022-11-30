<?php

namespace PHell\Operators;

use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\LambdaFunction;
use PHell\Flow\Functions\Parenthesis\ValidatorFunctionParenthesis;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Functions\UseProxyOriginFunctionObject;
use PHell\Flow\Main\Code;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Command;
use PHell\Flow\Main\Returns\ExecutionResult;

class NewFunction implements VisibilityAffected, Command
{
    private string $visibility = FunctionObject::VISIBILITY_PRIVATE;

    /**
     * @param string[]|null $allowedVariables
     * @param string[]|null $allowedFunctions
     */
    public function __construct(
        private readonly string $name,
        private readonly ValidatorFunctionParenthesis $parenthesis,
        private readonly Code $code,
        private readonly ?array $allowedVariables = null,
        private readonly ?array $allowedFunctions = null,
        private readonly bool $restrictWrite = false // restricts write access to origin
    ) { }

    public function changeVisibility(string $visibility): void
    {
        $this->visibility = $visibility;
    }

    public function execute(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ExecutionResult
    {
        $origin = $currentEnvironment->getObject();
        if ($this->allowedVariables !== null || $this->allowedFunctions !== null) {
            $origin = new UseProxyOriginFunctionObject($origin, $this->allowedVariables, $this->allowedFunctions, $this->restrictWrite);
        }

        $function = new LambdaFunction($this->name, $origin, $this->parenthesis, $this->code);
        switch ($this->visibility) {
            case FunctionObject::VISIBILITY_PUBLIC:
                $currentEnvironment->getObject()->addPublicFunction($function);
                break;
            case FunctionObject::VISIBILITY_PROTECTED:
                $currentEnvironment->getObject()->addProtectedFunction($function);
                break;
            default:
                $currentEnvironment->getObject()->addPrivateFunction($function);
        }

        return new ExecutionResult();
    }
}
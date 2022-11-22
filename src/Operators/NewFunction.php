<?php

namespace PHell\Operators;

use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\LambdaFunction;
use PHell\Flow\Functions\Parenthesis\ValidatorFunctionParenthesis;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\Code;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Command;
use PHell\Flow\Main\Returns\ExecutionResult;

class NewFunction implements VisibilityAffected, Command
{
    private string $visibility = FunctionObject::VISIBILITY_PRIVATE;

    /**
     * @param string $name
     * @param ValidatorFunctionParenthesis $parenthesis
     * @param Code $code
     * @param Variable[]|null $useStrictVariables
     */
    public function __construct(
        private readonly string $name,
        private readonly ValidatorFunctionParenthesis $parenthesis,
        private readonly Code $code,
        private readonly ?array $useStrictVariables = null
        //TODO private readonly bool copy = false / restricts write access to origin
    ) { }

    public function changeVisibility(string $visibility): void
    {
        $this->visibility = $visibility;
    }

    public function execute(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ExecutionResult
    {
        $origin = $currentEnvironment->getObject();
        if ($this->useStrictVariables !== null) {
            //TODO proxy origin here with restrictions??
            //TODO maybe introduce copy function?
        }
        //TODO if strict then $currentEnvironment is scewed : must be replaced by sth like "use ($var1, $var2)"
        $function = new LambdaFunction($this->name, $currentEnvironment, $this->parenthesis, $this->code);
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
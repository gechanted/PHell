<?php

namespace PHell\Flow\Functions;

use PHell\Flow\Functions\Parenthesis\NamedDataFunctionParenthesis;
use PHell\Flow\Functions\Parenthesis\ValidatorFunctionParenthesis;
use PHell\Flow\Main\Code;
use PHell\Flow\Main\Statement;

/**
 * the simple, not executed function
 */
class LambdaFunction
{

    public function __construct(
        private readonly string              $name,
        private readonly ?FunctionObject     $origin,
        private readonly ValidatorFunctionParenthesis $parenthesis,
        private readonly Code                $code
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParenthesis(): ValidatorFunctionParenthesis
    {
        return $this->parenthesis;
    }

    public function dumpParenthesis(): string
    {
        $dump = '';
        foreach ($this->parenthesis->getParameters() as $parameter) {
            if ($dump !== ''){
                $dump .= ', ';
            }
            $dump .= $parameter->getDatatype()->dumpType() . ($parameter->isOptional() ? '(opt)' : '');
        }

        return $dump;
    }

    public function generateRunningFunction(NamedDataFunctionParenthesis $parenthesis, FunctionObject $stack, ?FunctionObject $calledOn = null): Statement
    {
        $name = ($this->origin === null ? '' : $this->origin->getName().':') . $this->name; //add the topfunction:subfunction
        //add here the called on mechanic // a functionobject knows its child with this
        $origin = $this->origin;
        if ($calledOn !== $this->origin) {
            if ($calledOn instanceof OriginCallProxyFunctionObject) {
                $calledOn = $calledOn->getCalled();
            }
            $origin = new OriginCallProxyFunctionObject($this->origin, $calledOn);
        }
        return new RunningFunction(new FunctionObject($name, $stack, $origin, $parenthesis), $this->code, $parenthesis->getReturnType());
    }

    public function getCode(): Code
    {
        return $this->code;
    }
}
<?php

namespace PHell\Flow\Functions;

use PHell\Code\Code;

/**
 * the simple, not executed function
 */
class LambdaFunction
{

    public function __construct(
        private readonly string              $name,
        private readonly ?FunctionObject     $origin,
        private readonly FunctionParenthesis $parenthesis,
        private readonly Code                $code
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParenthesis(): FunctionParenthesis
    {
        return $this->parenthesis;
    }
}
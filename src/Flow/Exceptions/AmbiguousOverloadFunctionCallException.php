<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Functions\LambdaFunction;

class AmbiguousOverloadFunctionCallException extends RuntimeException
{
    /**
     * @param LambdaFunction[] $functions
     * @param int[] $score
     */
    public function __construct(array $functions, array $score)
    {
        $dump = '';
        for ($counter = 0; $counter < count($functions); $counter++) {
            $dump .= $counter . ': ' . $score[$counter] . ' -> (';
            foreach ($functions[$counter]->getParenthesis()->getParameters() as $params) {
                $dump .= $params->getDatatype()->dumpType() . ($params->isOptional() ? ' (opt) ' : '') .',';
            }
            $dump .= PHP_EOL;
        }
        parent::__construct(
            'AmbiguousOverloadFunctionCallException',
            'The execution of the function was ambiguous: multiple functions can be executed' . PHP_EOL .
            'if you shove an int the runtime will pick according to the number the function to progress further' . PHP_EOL .
            $dump
        );
    }
}
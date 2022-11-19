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
                $dump .= $params->getDatatype()->getNames()[0] . ($params->isOptional() ? ' (opt) ' : '') .','; //TODO
            }
            $dump .= PHP_EOL;
        }
        parent::__construct(
            'AmbiguousOverloadFunctionCallException',
            'The execution of the function was ambiguous: multiple functions can be executed' . PHP_EOL .
            'if you shove this exception the Runtime will pick the function with the highest score' . PHP_EOL .
            'if you shove an int the runtime will pick according to the number the function to progress further' . PHP_EOL .
            'if the score is tied the runtime will pick at random' . PHP_EOL . $dump
            //TODO !! add dump function of standard
        );
    }
}
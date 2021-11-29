<?php

namespace PHell\Flow\Functions;

use PHell\Code\Datatypes\DatatypeInterface;

class FunctionParenthesis
{

    /**
     * $vars  = array['index' => 'datatype']
     * $returntype = 'datatype'
     * // visibility is handled in containing classes
     * // strict is handled with the originator
     * //final could be implemented
     * //abstract ?
     * //static is implementable with the addition of the LambdaFunction
     * @param DatatypeInterface[] $vars
     * @param DatatypeInterface $returnType
     */
    public function __construct(array $vars, DatatypeInterface $returnType)
    {
    }
}
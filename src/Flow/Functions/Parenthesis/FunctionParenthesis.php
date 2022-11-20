<?php

namespace PHell\Flow\Functions\Parenthesis;

use PHell\Flow\Data\Datatypes\DatatypeInterface;

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
     * @param FunctionParenthesisParameter[] $parameters
     * @param DatatypeInterface $returnType
     */
    public function __construct(
        private array $parameters,
        private readonly DatatypeInterface $returnType
    ) {}

    /**
     * @return FunctionParenthesisParameter[]
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getReturnType(): DatatypeInterface
    {
        return $this->returnType;
    }

    public function addParameter(FunctionParenthesisParameter $parameter): void
    {
        $this->parameters[] = $parameter;
    }

}
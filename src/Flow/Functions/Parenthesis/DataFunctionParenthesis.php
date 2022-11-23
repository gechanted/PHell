<?php

namespace PHell\Flow\Functions\Parenthesis;

use PHell\Flow\Data\Datatypes\DatatypeInterface;

class DataFunctionParenthesis
{

    /**
     * $vars  = array['index' => 'datatype']
     * $returntype = 'datatype'
     * // visibility is handled in containing classes
     * // strict is handled with the originator
     * //final could be implemented
     * //abstract ?
     * //static is implementable with the addition of the LambdaFunction
     * @param DataFunctionParenthesisParameter[] $parameters
     * @param DatatypeInterface $returnType
     */
    public function __construct(
        private array $parameters,
        private readonly DatatypeInterface $returnType
    ) {}

    /**
     * @return DataFunctionParenthesisParameter[]
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getReturnType(): DatatypeInterface
    {
        return $this->returnType;
    }

    public function addParameter(DataFunctionParenthesisParameter $parameter): void
    {
        $this->parameters[] = $parameter;
    }

}
<?php

namespace PHell\Flow\Functions;

use PHell\Flow\Data\DatatypeValidators\DatatypeValidatorInterface;

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
     * @param DatatypeValidatorInterface $returnType
     */
    public function __construct(
        private readonly array $parameters,
        private readonly DatatypeValidatorInterface $returnType
    ) {}

    /**
     * @return FunctionParenthesisParameter[]
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getReturnType(): DatatypeValidatorInterface
    {
        return $this->returnType;
    }

}
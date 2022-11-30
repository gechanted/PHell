<?php

namespace PHell\Flow\Functions\Parenthesis;

use PHell\Flow\Data\Datatypes\DatatypeInterface;

class ValidatorFunctionParenthesis
{

    /**
     * $vars  = array['index' => 'datatype']
     * $returntype = 'datatypevalidator'
     * // visibility is handled in containing classes
     * // strict is handled with the originator
     * //final could be implemented
     * //abstract ?
     * //static is implementable with the addition of the LambdaFunction
     * @param ValidatorFunctionParenthesisParameter[] $parameters
     * @param DatatypeInterface $returnType
     */
    public function __construct(
        private readonly array $parameters,
        private readonly DatatypeInterface $returnType
    ) {}

    /**
     * @return ValidatorFunctionParenthesisParameter[]
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getReturnType(): DatatypeInterface
    {
        return $this->returnType;
    }

    public function getHash(): string
    {
        $hash = '';
        foreach ($this->parameters as $parameter) {
            if ($hash !== '') {
                $hash .= '+';
            }
            $hash .= $parameter->getDatatype()->dumpType();
        }
        return $hash;
    }

}
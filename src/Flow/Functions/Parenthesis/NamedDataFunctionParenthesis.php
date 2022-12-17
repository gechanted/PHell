<?php

namespace PHell\Flow\Functions\Parenthesis;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Datatypes\DatatypeInterface;

class NamedDataFunctionParenthesis extends DataFunctionParenthesis
{

    /**
     * @param DatatypeInterface $returnType
     * @param NamedDataFunctionParenthesisParameter[] $parameters
     */
    public function __construct(DatatypeInterface $returnType, private array $parameters = [])
    {
        parent::__construct([], $returnType); //give in the return type, overwriting the parameters
    }

    /**
     * @return NamedDataFunctionParenthesisParameter[]
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getParameter(string $name): NamedDataFunctionParenthesisParameter
    {
        foreach ($this->getParameters() as $parameter) {
            if ($parameter->getName() === $name) {
                return $parameter;
            }
        }
        throw new ShouldntHappenException(); //TODO maybe : this is not the cleanest/user-friendliest way
    }

    public function addParameter(DataFunctionParenthesisParameter $parameter): void
    {
        $this->parameters[] = $parameter;
    }
}
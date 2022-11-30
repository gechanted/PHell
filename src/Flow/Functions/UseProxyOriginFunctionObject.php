<?php

namespace PHell\Flow\Functions;

use PHell\Flow\Data\Data\DataInterface;

class UseProxyOriginFunctionObject extends FunctionObject //TODO maybe turn into Interface
{
    /**
     * @param string[] $allowedVariables
     * @param string[] $allowedFunctionNames
     */
    public function __construct(
        private readonly FunctionObject $actualObject,
        private readonly ?array         $allowedVariables,
        private readonly ?array         $allowedFunctionNames,
        private readonly bool           $restrictWrite,
    )
    {
        parent::__construct('', null, null, null);
    }

    public function getNormalVar(string $index): ?DataInterface
    {
        if ($this->allowedVariables !== null && in_array($index, $this->allowedVariables, true) === false) {
            return null;
        }
        return $this->actualObject->getNormalVar($index);
    }

    public function checkAndSetOriginatorVar(string $index, ?DataInterface $value): bool
    {
        if ($this->restrictWrite || ($this->allowedVariables !== null && in_array($index, $this->allowedVariables, true) === false)) {
            return false;
        }

        return $this->actualObject->setNormalVar($index, $value);
    }


    public function getNormalFunction(string $index): array
    {
        if (in_array($index, $this->allowedFunctionNames, true) === false) {
            return [];
        }
        return $this->actualObject->getNormalFunction($index);
    }
}
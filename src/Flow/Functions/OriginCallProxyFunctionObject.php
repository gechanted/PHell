<?php

namespace PHell\Flow\Functions;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Datatypes\DatatypeInterface;
use PHell\Flow\Data\Datatypes\DatatypeValidation;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;
use PHell\Operators\Variable;

/**
 * Imitates the $caller (which extends the $origin)
 * but when asked after origin returns $origin->origin
 */
class OriginCallProxyFunctionObject extends FunctionObject
{

    public function __construct(private readonly FunctionObject $origin, private readonly FunctionObject $actualCalled)
    {
        parent::__construct('', null, null, null);
    }

    public function getCalled(): FunctionObject
    {
        return $this->actualCalled;
    }

    //TODO !! TODAY I DECIDED: origin functionality also calls extended object functionality
    // even child functionality (public and protected for both, it only calls privates in the "true" origin objects)
    // (actualCalled + everything upper)

    /**
     * @inheritDoc
     *
     * here's the swap
     * everything else is just redirecting to caller
     * //TODO
     */
    public function getNormalVar(string $index): ?DataInterface
    {
        if ($index === Variable::SPECIAL_VAR_ORIGIN) {
            return $this->origin;
        }
        return $this->origin->getNormalVar($index);
    }

    /** @inheritDoc */ //TODO
    public function getNormalFunction(string $index): array
    {
        return $this->origin->getNormalFunction($index);
    }

    //TODO !! origin functionalities need to be be directed towards origin
//-------------------------------------------------------------------------------------------------------    
    
    
    public function realValidate(DatatypeInterface $datatype): DatatypeValidation
    {
        return $this->actualCalled->realValidate($datatype);
    }

    public function getNames(): array
    {
        return $this->actualCalled->getNames();
    }
    
    public function dumpType(): string
    {
        return $this->actualCalled->dumpType();
    }
    
    public function getName(): string
    {
        return $this->actualCalled->getName();
    }
    
    public function v(): FunctionObject
    {
        return $this->actualCalled->v();
    }
    
    public function phpV()
    {
        return $this->actualCalled->phpV();
    }
    
    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        return $this->actualCalled->getValue($currentEnvironment, $exHandler);
    }
    
    public function dumpValue(): string
    {
        return $this->actualCalled->dumpValue();
    }
    
    public function __toString(): string
    {
        return $this->actualCalled->__toString();
    }
    
    public function extend(FunctionObject $newParent, CodeExceptionHandler $exHandler): ExecutionResult
    {
        return $this->actualCalled->extend($newParent, $exHandler);
    }
    
    public function extendWithoutPrecaution(FunctionObject $newParent)
    {
        $this->actualCalled->extendWithoutPrecaution($newParent);
    }
    
    public function checkExtensionRecursion(FunctionObject $object): bool
    {
        return $this->actualCalled->checkExtensionRecursion($object);
    }
    
    public function checkExtensionRecursionParents(FunctionObject $object): bool
    {
        return $this->actualCalled->checkExtensionRecursionParents($object);
    }
    
    public function getAccessibleVars(): array
    {
        return $this->actualCalled->getAccessibleVars();
    }
    
    public function getAccessibleVarsParents(): array
    {
        return $this->actualCalled->getAccessibleVarsParents();
    }
    
    public function addPublicFunction(LambdaFunction $function): void
    {
        $this->actualCalled->addPublicFunction($function);
    }
    
    public function addProtectedFunction(LambdaFunction $function): void
    {
        $this->actualCalled->addProtectedFunction($function);
    }
    
    public function addPrivateFunction(LambdaFunction $function): void
    {
        $this->actualCalled->addPrivateFunction($function);
    }
    
    public function getPrivateFunctions(string $index): array
    {
        return $this->actualCalled->getPrivateFunctions($index);
    }
    
    public function getProtectedFunctions(string $index): array
    {
        return $this->actualCalled->getProtectedFunctions($index);
    }
    
    public function getPublicFunctions(string $index): array
    {
        return $this->actualCalled->getPublicFunctions($index);
    }
    
    public function getStackFunction(string $index): array
    {
        return $this->actualCalled->getStackFunction($index);
    }
    
    public function getInnerObjectFunction(string $index): array
    {
        return $this->actualCalled->getInnerObjectFunction($index);
    }
    
    public function getObjectPubliclyAvailableFunction(string $index): array
    {
        return $this->actualCalled->getObjectPubliclyAvailableFunction($index);
    }
    
    public function setNormalVar(string $index, DataInterface $value, string $visibility = self::VISIBILITY_PRIVATE): bool
    {
        return $this->actualCalled->setNormalVar($index, $value, $visibility);
    }
    
    public function checkAndSetOriginatorVar(string $index, ?DataInterface $value): bool
    {
        return $this->actualCalled->checkAndSetOriginatorVar($index, $value);
    }
    
    public function getObjectPubliclyAvailableVar(string $index): ?DataInterface
    {
        return $this->actualCalled->getObjectPubliclyAvailableVar($index);
    }
    
    public function setObjectOuterVar(string $index, $value): bool
    {
        return $this->actualCalled->setObjectOuterVar($index, $value);
    }

    public function getPublicAndProtectedVariable(string $index): ?DataInterface
    {
        return $this->actualCalled->getPublicAndProtectedVariable($index);
    }
    
    public function setPublicAndProtectedVariable(string $index, ?DataInterface $value): bool
    {
        return $this->actualCalled->setPublicAndProtectedVariable($index, $value);
    }



}
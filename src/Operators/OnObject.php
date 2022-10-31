<?php

namespace PHell\Operators;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use Phell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;
use PHell\Flow\Main\Statement;

/**
 *  . or  ->
 * the OnObject just changes the scope of the following
 */
class OnObject extends EasyStatement
{
    public function __construct(private readonly Statement $object, private readonly ScopeAffected|Statement $further)
    {
    }

    protected function value(FunctionObject $currentEnvironment): ReturnLoad
    {
        $rload = $this->object->getValue($currentEnvironment, $this->upper);
        if ($rload instanceof ExceptionReturnLoad) { return $rload; }
        if ($rload instanceof DataReturnLoad === false) { throw new ShouldntHappenException(); }
        $object = $rload->getData();

        if ($object === $currentEnvironment) {
            $this->further->changeScope(ScopeAffected::SCOPE_THIS_OBJECT_CALL);
        } else {
            $this->further->changeScope($object);
        }

        return $this->further->getValue($currentEnvironment, $this->upper);
    }
}
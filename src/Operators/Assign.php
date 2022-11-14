<?php

namespace PHell\Operators;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use Phell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;
use PHell\Flow\Main\Statement;

class Assign extends EasyStatement implements VisibilityAffected
{

    public function __construct(private readonly Assignable $variable, private readonly Statement $statement)
    {
    }

    protected function value(FunctionObject $currentEnvironment): ReturnLoad
    {
        $returnLoad = $this->statement->getValue($currentEnvironment, $this->upper);
        if ($returnLoad instanceof ExceptionReturnLoad) { return $returnLoad; }
        if ($returnLoad instanceof DataReturnLoad === false) { throw new ShouldntHappenException(); }
        return $this->variable->set($currentEnvironment, $returnLoad->getData());
    }

    public function changeVisibility(string $visibility)
    {
        $this->variable->changeVisibility($visibility);
    }
}
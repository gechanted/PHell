<?php

namespace PHell\Operators;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
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

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        $returnLoad = $this->statement->getValue($currentEnvironment, $exHandler);
        if ($returnLoad instanceof ExceptionReturnLoad) { return $returnLoad; }
        if ($returnLoad instanceof DataReturnLoad === false) { throw new ShouldntHappenException(); }
        return $this->variable->set($currentEnvironment, $exHandler, $returnLoad->getData());
    }

    public function changeVisibility(string $visibility): void
    {
        //TODO if var is an OnOject this crashes: so if $var not VisibilityAffected throw an actual Exception => this is Syntax Error
        $this->variable->changeVisibility($visibility);
    }
}
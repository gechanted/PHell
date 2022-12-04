<?php

namespace PHell\Operators;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Exceptions\SyntaxErrorException;
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
        if ($returnLoad instanceof DataReturnLoad === false) { return $returnLoad; }
        return $this->variable->set($currentEnvironment, $exHandler, $returnLoad->getData());
    }

    /** @throws SyntaxErrorException */
    public function changeVisibility(string $visibility): void
    {
        if ($this->variable instanceof VisibilityAffected === false) {
            throw new SyntaxErrorException('Adjustments of the Visibility cannot be done on object-related calls:' . PHP_EOL .
                ' (public/protected $object->variable = "sth") is not allowed');
        }
        $this->variable->changeVisibility($visibility);
    }
}
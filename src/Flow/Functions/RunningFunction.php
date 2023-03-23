<?php

namespace PHell\Flow\Functions;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Data\Voi;
use PHell\Flow\Data\Datatypes\DatatypeInterface;
use PHell\Flow\Exceptions\OverBreakException;
use PHell\Flow\Exceptions\OverContinueException;
use PHell\Flow\Exceptions\OverShoveException;
use PHell\Flow\Exceptions\ReturnValueDoesntMatchType;
use PHell\Flow\Main\Code;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\CommandActions\BreakAction;
use PHell\Flow\Main\CommandActions\ContinueAction;
use PHell\Flow\Main\CommandActions\ReturnAction;
use PHell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\CommandActions\ShoveAction;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\CatapultReturnLoad;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;

class RunningFunction extends EasyStatement
{

    //TODO maybe add a check on transmitException if the Exceptions are in function description (warning if not)

    public function __construct(private readonly FunctionObject      $object,
                                private readonly Code                $code,
                                private readonly DatatypeInterface   $returnType)
    {
    }

    public function getReturnType(): DatatypeInterface
    {
        return $this->returnType;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    private bool $active = false;

    public function getObject(): FunctionObject
    {
        return $this->object;
    }

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        $this->active = true;
        foreach ($this->code->getCommands() as $statement) {
            $result = $statement->execute($this, $exHandler);
            if ($result->isActionRequired()) {

                $action = $result->getAction();
                if ($action instanceof ReturnAction) {
                    if ($action->getFunction() !== null && $action->getFunction() !== $this) {
                        $this->active = false;
                        return new CatapultReturnLoad($action->getFunction(), $action->getValue());
                    }
                    $this->active = false;
                    return $this->return($action->getValue(), $exHandler);


                } elseif ($action instanceof ContinueAction) {
                    $r = $exHandler->handle(new OverContinueException());
                    $this->active = false;
                    return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($r->getHandler(), new ExecutionResult())));

                } elseif ($action instanceof BreakAction) {
                    $r = $exHandler->handle(new OverBreakException());
                    $this->active = false;
                    return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($r->getHandler(), new ExecutionResult())));

                  } elseif ($action instanceof ShoveAction) {
                    $r = $exHandler->handle(new OverShoveException());
                    $this->active = false;
                    return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($r->getHandler(), new ExecutionResult())));


                } elseif ($action instanceof ReturningExceptionAction) {
                    $this->active = false;
                    return new ExceptionReturnLoad(new ExecutionResult($action));

                } else {
                    $this->active = false;
                    //TODO maybe just log this and return $action
                    throw new ShouldntHappenException();
                }
            }
        }

        $this->active = false;
        return $this->return(new Voi(), $exHandler);
    }

    private function return(DataInterface $value, CodeExceptionHandler $exHandler): ReturnLoad
    {
        if ($this->returnType->validate($value)) {
            return new DataReturnLoad($value);
        }
        $r = $exHandler->handle(new ReturnValueDoesntMatchType());
        return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($r->getHandler(), new ExecutionResult())));
    }
}
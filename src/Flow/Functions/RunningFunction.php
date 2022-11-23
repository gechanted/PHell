<?php

namespace PHell\Flow\Functions;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Data\Voi;
use PHell\Flow\Data\Datatypes\DatatypeInterface;
use PHell\Flow\Exceptions\OverBreakException;
use PHell\Flow\Exceptions\OverContinueException;
use PHell\Flow\Exceptions\ReturnValueDoesntMatchType;
use Phell\Flow\Main\Code;
use PHell\Flow\Main\CodeExceptionHandler;
use Phell\Flow\Main\CommandActions\BreakAction;
use Phell\Flow\Main\CommandActions\ContinueAction;
use Phell\Flow\Main\CommandActions\ReturnAction;
use Phell\Flow\Main\CommandActions\ReturningExceptionAction;
use Phell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\CatapultReturnLoad;
use PHell\Flow\Main\Returns\DataReturnLoad;
use Phell\Flow\Main\Returns\ExceptionReturnLoad;
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
        foreach ($this->code->getStatements() as $statement) {
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
                    $r = $exHandler->transmit(new OverContinueException());
                    $this->active = false;
                    return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($r->getHandler(), new ExecutionResult())));

                } elseif ($action instanceof BreakAction) {
                    $r = $exHandler->transmit(new OverBreakException());
                    $this->active = false;
                    return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($r->getHandler(), new ExecutionResult())));

                } elseif ($action instanceof ReturningExceptionAction) {
                    $this->active = false;
                    return new ExceptionReturnLoad(new ExecutionResult($action));

                    //TODO if shove action => throw exception
                    // can this be done with the other Action? in one Exception instead of this clusterf

                } else {
                    $this->active = false;
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
        $r = $exHandler->transmit(new ReturnValueDoesntMatchType());
        return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($r->getHandler(), new ExecutionResult())));
    }
}
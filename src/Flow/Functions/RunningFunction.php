<?php

namespace PHell\Flow\Functions;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Data\Voi;
use PHell\Flow\Data\DatatypeValidators\DatatypeValidatorInterface;
use PHell\Flow\Exceptions\Exception;
use PHell\Flow\Main\Code;
use PHell\Flow\Main\CommandActions\ContinueAction;
use PHell\Flow\Main\CommandActions\ReturnAction;
use PHell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\ExceptionReturnLoad;
use PHell\Flow\Main\ReturnLoad;

class RunningFunction extends EasyStatement
{

    //TODO maybe add a check on transmitException if the Exceptions are in function description (warning if not)

    public function __construct(private readonly FunctionObject             $object,
                                private readonly Code                       $code,
                                private readonly DatatypeValidatorInterface $returnType)
    {
    }

    public function value(FunctionObject $currentEnvironment): ReturnLoad
    {
        foreach ($this->code->getStatements() as $statement) {
            $result = $statement->execute($this->object, $this);
            if ($result->isActionRequired()) {

                $action = $result->getAction();
                if ($action instanceof ReturnAction) {
                    return $this->return($action->getValue());
                } elseif ($action instanceof ContinueAction) {
                    // TODO throw error/exception here
                } elseif ($action instanceof ReturningExceptionAction) {
                    return new ExceptionReturnLoad();

                    //TODO on redo command -> throw exception since it belong to loops

                } else {
                    throw new ShouldntHappenException();
                }
            }
        }

        return $this->return(new Voi());
    }

    private function return(DataInterface $value): ReturnLoad
    {
        if ($this->returnType->validate($value)) {
            return new ReturnLoad($value);
        }
        //TODO throw specialized Exception
        $this->upper->transmit(new Exception());
        return new ExceptionReturnLoad();
    }
}
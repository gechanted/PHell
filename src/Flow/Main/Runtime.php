<?php

namespace PHell\Flow\Main;

use PHell\Flow\Data\Data\Voi;
use PHell\Flow\Data\Datatypes\UnknownDatatype;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Functions\StandardFunctions\DTvalidate;
use PHell\Flow\Functions\StandardFunctions\Dump;
use PHell\Flow\Functions\StandardFunctions\EchoFunction;
use PHell\Flow\Functions\StandardFunctions\ReflectObject;
use PHell\Flow\Main\CommandActions\ReturnAction;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;

class Runtime extends RunningFunction
{

    public function execute(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ExecutionResult
    {
        $return = $this->getValue($currentEnvironment, $exHandler);
        if ($return instanceof DataReturnLoad && $return->getData() instanceof Voi === false) {
            return new ExecutionResult(new ReturnAction($return->getData()));
        }
        return self::returnLoadToExecutionResult($return);
    }

    public function __construct(Code $code)
    {
        $object = new FunctionObject('', null, null, null);

        //add standard functions here
        //TODO maybe use a DI here for hacky modding?
        $object->addPublicFunction(new Dump());
        $object->addPublicFunction(new ReflectObject());
        $object->addPublicFunction(new DTvalidate());
        $object->addPublicFunction(new EchoFunction());


        parent::__construct($object, $code, new UnknownDatatype());
    }
}
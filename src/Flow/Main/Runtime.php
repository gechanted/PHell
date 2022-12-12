<?php

namespace PHell\Flow\Main;

use PHell\Flow\Data\Datatypes\UnknownDatatype;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Functions\StandardFunctions\Dump;
use PHell\Flow\Functions\StandardFunctions\ReflectObject;
use PHell\Flow\Main\Returns\ExceptionHandlingResult;

class Runtime extends RunningFunction implements CodeExceptionHandler
{

    public function __construct(Code $code)
    {
        $object = new FunctionObject('', null, null, null);

        //add standard functions here
        $object->addPublicFunction(new Dump());
        $object->addPublicFunction(new ReflectObject());


        parent::__construct($object, $code, new UnknownDatatype());
    }

    public function transmit(FunctionObject $exception): ExceptionHandlingResult
    {
        // TODO: Implement transmit() method.
    }
}
<?php

namespace PHell\Flow\Functions;

use PHell\Flow\Data\Data\Boolea;
use PHell\Flow\Functions\Parenthesis\FunctionParenthesis;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\ReturnLoad;

class RunningPHPFunction extends EasyStatement
{

    public function __construct(private readonly string $name, private readonly FunctionParenthesis $parenthesis)
    {
    }

    public function value(FunctionObject $currentEnvironment): ReturnLoad
    {
        $parameters = [];
        foreach ($this->parenthesis->getParameters() as $parameter) {
            $parameters[] = $parameter->getData()->v();
        }


        try {
            $result = call_user_func_array($this->name, $parameters);
        } catch (\Throwable $throwable) {
            //TODO do Exception
        }

        $return = null; //TODO convert from null to a useable Resource

        if (is_array($result)) {
            if ($return !== null) { /* TODO throw Exception */ }
        } if (is_bool($result)) {
            if ($return !== null) { /* TODO throw Exception */ }
            $return = new Boolea($result);
        } if (is_int($result)) {
        } if (is_string($result)) {
        } if (is_float($result)) {
        } if (is_object($result)) {
        } if (is_null($result)) {
        } if (is_resource($result)) {
        } else {
            //a closed resource?? ???
        }

//        return new ReturnLoad($return);
    }
}
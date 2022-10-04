<?php

namespace PHell\Flow\Functions;

use PHell\Code\Code;
use PHell\Code\DatatypeValidators\BooleanTypeValidator;
use PHell\Code\DatatypeValidators\FloatTypeValidator;
use PHell\Code\DatatypeValidators\IntegerTypeValidator;
use PHell\Code\DatatypeValidators\StringTypeValidator;
use PHell\Code\DatatypeValidators\UnknownDatatypeValidator;
use ReflectionFunction;

class PHPFunction extends LambdaFunction
{

    public function __construct(private readonly string $name)
    {
        $function = new ReflectionFunction($name);
        $params = [];
        foreach ($function->getParameters() as $parameter) {
            if ($parameter->getType() === null) {
                $datatype = new UnknownDatatypeValidator();
            } else if($parameter->getType()->getName() === 'string') {
                $datatype = new StringTypeValidator();
            } else if($parameter->getType()->getName() === 'int') {
                $datatype = new IntegerTypeValidator();
            } else if($parameter->getType()->getName() === 'float') {
                $datatype = new FloatTypeValidator();
            } else if($parameter->getType()->getName() === 'array') {
                //TODO do
            } else if($parameter->getType()->getName() === 'bool') {
                $datatype = new BooleanTypeValidator();
            } else {
                $datatype = new UnknownDatatypeValidator();
            }
            $params[] = new ValidatorFunctionParenthesisParameter($parameter->getName(), $datatype);
        }
        $parenthesis = new ValidatorFunctionParenthesis($params, new UnknownDatatypeValidator());

        parent::__construct($name, null, $parenthesis, new Code());//TODO CODE is not valid
    }

    public function generateRunningFunction(FunctionParenthesis $parenthesis, FunctionObject $stack)
    {
        $parameters = [];
        foreach ($parenthesis->getParameters() as $parameter) {
            $parameters[] = $parameter;
        }
        $result = call_user_func_array($this->name, $parameters);

        if (is_array($result)) {
        } if (is_bool($result)) {
        } if (is_int($result)) {
        } if (is_string($result)) {
        } if (is_float($result)) {
        } if (is_object($result)) {
        } if (is_null($result)) {
        } if (is_resource($result)) {
        } else {
            //a closed resource?? ???
        }
    }
}
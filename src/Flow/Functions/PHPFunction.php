<?php

namespace PHell\Flow\Functions;

use PHell\Flow\Data\DatatypeValidators\ArrayTypeValidator;
use PHell\Flow\Data\DatatypeValidators\BooleanTypeValidator;
use PHell\Flow\Data\DatatypeValidators\FloatTypeValidator;
use PHell\Flow\Data\DatatypeValidators\IntegerTypeValidator;
use PHell\Flow\Data\DatatypeValidators\StringTypeValidator;
use PHell\Flow\Data\DatatypeValidators\UnknownDatatypeValidator;
use PHell\Flow\Main\Code;
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
                $datatype = new ArrayTypeValidator();
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
        try {
            $result = call_user_func_array($this->name, $parameters);
        } catch (\Throwable $throwable) {

        }


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
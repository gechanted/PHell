<?php

namespace PHell\Flow\Functions;

use PHell\Flow\Data\Data\UnexecutedFunctionCollection;
use PHell\Flow\Data\DatatypeValidators\UnknownDatatypeValidator;
use PHell\Flow\Exceptions\Exception;
use PHell\Flow\Functions\Parenthesis\FunctionParenthesis;

class FunctionResolver
{

    //TODO options in config
    //in case of 2 fitting overload functions
    public const INDECISIVE_OVERLOAD_APPROACH_CANCEL = 'indecisive overload approach cancel';
    public const INDECISIVE_OVERLOAD_APPROACH_WARN = 'indecisive overload approach warn';
    public const INDECISIVE_OVERLOAD_APPROACH_RANDOM = 'indecisive overload approach random';
    public const INDECISIVE_OVERLOAD_APPROACH_FITTING = 'indecisive overload approach fitting';


    /**
     * @param FunctionParenthesis $given
     * @param UnexecutedFunctionCollection $possibleOptions
     */
    public static function resolve(FunctionParenthesis $given, UnexecutedFunctionCollection $possibleOptions): Exception|LambdaFunction
    {
        $approach = self::INDECISIVE_OVERLOAD_APPROACH_FITTING;
        $best = $bestDepth = null;

        foreach ($possibleOptions->v() as $option) {
            $depth = 0;

            if ($given->getReturnType() instanceof UnknownDatatypeValidator === false) {
                if ($given->getReturnType()->validate( $option->getParenthesis()->getReturnType())->isSuccess() === false) {
                    continue;
                }
            }
            foreach ($option->getParenthesis()->getParameters() as $optionParameter) {
                foreach ($given->getParameters() as $targetParameter) { //TODO !!! doesnt work foreach must be on both
                    //TODO !!! doesnt check if more parameters are required, and whats optional
                    $validation = $optionParameter->getDatatype()-> validate($targetParameter->getData());
                    if ($validation->isSuccess() === false) {
                        continue 3; //continue with next option, because this doesn't fit
                    }
                    $depth += $validation->getDepth();
                }
            }

            //fits
            if ($best === null) {
                if ($approach === self::INDECISIVE_OVERLOAD_APPROACH_RANDOM) {
                    return $option;
                }
                $best = $option;
                $bestDepth = $depth;

            } else {
                switch ($approach) {
                    case self::INDECISIVE_OVERLOAD_APPROACH_CANCEL:
                        return new Exception();//TODO correct exception here

                    case self::INDECISIVE_OVERLOAD_APPROACH_WARN:
                        //TODO implement warning system
                    case self::INDECISIVE_OVERLOAD_APPROACH_FITTING:
                        if ($bestDepth > $depth) {  //lower depth means less abstract
                            $best = $option;
                            $bestDepth = $depth;
                        }
                        if ($bestDepth === $depth) {
                            //TODO warn
                        }

                }
            }

        }

        return $best;
    }
}
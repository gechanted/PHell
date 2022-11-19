<?php

namespace PHell\Flow\Functions;

use PHell\Flow\Data\Data\UnexecutedFunctionCollection;
use PHell\Flow\Exceptions\AmbiguousOverloadFunctionCallException;
use PHell\Flow\Exceptions\Exception;
use PHell\Flow\Functions\Parenthesis\FunctionParenthesis;
use PHell\Flow\Main\CodeExceptionTransmitter;
use PHell\Flow\Main\Returns\ReturnLoad;

class FunctionResolver
{

    /**
     * @param FunctionParenthesis $given
     * @param UnexecutedFunctionCollection $possibleOptions
     */
    public static function resolve(FunctionParenthesis $given, UnexecutedFunctionCollection $possibleOptions, CodeExceptionTransmitter $upper): ReturnLoad|LambdaFunction
    {
        $solutions = [];
        $solutionScores = [];

        foreach ($possibleOptions->v() as $option) {
            $depth = 0;

//TODO maybe add returntype requirements: the next function requires a certain type, so this function has the return the certain type

//            if ($given->getReturnType() instanceof UnknownDatatypeValidator === false) {
//                if ($option->getParenthesis()->getReturnType()->validate( $given->getReturnType())->isSuccess() === false) {
//                    continue;
//                }
//            }

            $oParams = $option->getParenthesis()->getParameters();
            $gParams= $given->getParameters();
            $counter = 0;
            while (true) {
                //loop
                //element of given and option
                if (array_key_exists($counter, $oParams) === false) {
                    break;
                }
                $optionParameter = $oParams[$counter];
                if (array_key_exists($counter, $gParams) === false) {
                    if ($optionParameter->isOptional()) {
                        continue;
                    } else {
                        continue 2; //continue with next option, because this doesn't fit
                    }
                }
                $targetParameter = $gParams[$counter];

                //validate
                $validation = $optionParameter->getDatatype()-> validate($targetParameter->getData());
                if ($validation->isSuccess() === false) {
                    continue 2; //continue with next option, because this doesn't fit
                }
                $depth += $validation->getDepth();
            }

            //fits
            $solutions[] = $option;
            $solutionScores[] = $option;

        }

        //TODO if best as an array is filled with more than 2 results
        // also throw if best is empty => there are no results
        $solutionCount = count($solutions);
        if ($solutionCount === 0) {
            //TODO throw no solution Exception
        }
        elseif ($solutionCount !== 1) {
            $return = $upper->transmit(new AmbiguousOverloadFunctionCallException($solutions, $solutionScores));
        }
        //TODO
        // if return is int
        //pick with int
        //else
        //executed first function with highest score
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

        return $best;
    }
}
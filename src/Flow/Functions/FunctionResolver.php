<?php

namespace PHell\Flow\Functions;

use PHell\Flow\Data\Data\UnexecutedFunctionCollection;
use PHell\Flow\Data\Datatypes\IntegerType;
use PHell\Flow\Exceptions\AmbiguousOverloadFunctionCallException;
use PHell\Flow\Exceptions\Exception;
use PHell\Flow\Exceptions\NoOverloadFunctionException;
use PHell\Flow\Functions\Parenthesis\FunctionParenthesis;
use PHell\Flow\Main\CodeExceptionHandler;
use Phell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\Returns\ExceptionHandlingResultNoShove;
use PHell\Flow\Main\Returns\ExceptionHandlingResultShove;
use Phell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;

class FunctionResolver
{

    /**
     * @param FunctionParenthesis $given
     * @param UnexecutedFunctionCollection $possibleOptions
     */
    public static function resolve(FunctionParenthesis $given, UnexecutedFunctionCollection $possibleOptions, CodeExceptionHandler $upper): ReturnLoad|LambdaFunction
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
            $gParams = $given->getParameters();
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


        //sort solutions after highest score
        $stringyfiedScores = [];
        foreach ($solutionScores as $key => $value) {
            $stringyfiedScores[(string) $key] = $value;
        }

        sort($stringyfiedScores);
        sort($solutionScores);

        $newSolution = [];
        foreach ($stringyfiedScores as $key => $value) {
            $newSolution = $solutions[(int) $key];
        }
        $solutions = $newSolution;

        $solutionCount = count($solutions);
        if ($solutionCount === 0) {
            $exceptionResult = $upper->transmit(new NoOverloadFunctionException());
            return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($exceptionResult->getHandler(), new ExecutionResult())));
        }
        elseif ($solutionCount !== 1) {
            $exceptionResult = $upper->transmit(new AmbiguousOverloadFunctionCallException($solutions, $solutionScores));
            if ($exceptionResult instanceof ExceptionHandlingResultNoShove) {
                return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($exceptionResult->getHandler(), new ExecutionResult())));
            } if ($exceptionResult instanceof ExceptionHandlingResultShove) {
                $shoveValue = $exceptionResult->getShoveBackValue();
                $intValidator = new IntegerType();
                if ($intValidator->validate($shoveValue)->isSuccess()) {
                    if (array_key_exists($shoveValue->v(), $solutions)) {
                        return $solutions[$shoveValue->v()];
                    } else {
                        return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($exceptionResult->getHandler(), new ExecutionResult())));
                    }
                } else {
                    return $solutions[0];
                }
            }
        }


        return $solutions[0];
    }
}
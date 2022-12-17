<?php

namespace PHell\Flow\Functions;

use PHell\Flow\Data\Data\UnexecutedFunctionCollection;
use PHell\Flow\Data\Datatypes\IntegerType;
use PHell\Flow\Exceptions\AmbiguousOverloadFunctionCallException;
use PHell\Flow\Exceptions\NoOverloadFunctionException;
use PHell\Flow\Functions\Parenthesis\DataFunctionParenthesis;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\Returns\ExceptionHandlingResultNoShove;
use PHell\Flow\Main\Returns\ExceptionHandlingResultShove;
use PHell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;

class FunctionResolver
{

    /**
     * @param DataFunctionParenthesis $given
     * @param UnexecutedFunctionCollection $possibleOptions
     */
    public static function resolve(DataFunctionParenthesis $given, UnexecutedFunctionCollection $possibleOptions, CodeExceptionHandler $exHandler): ReturnLoad|LambdaFunction
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
                $counter++;
            }

            //fits
            $solutions[] = $option;
            $solutionScores[] = $depth;

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
            $newSolution[] = $solutions[(int) $key];
        }
        $solutions = $newSolution;

        $solutionCount = count($solutions);
        if ($solutionCount === 0) {
            $exceptionResult = $exHandler->handle(new NoOverloadFunctionException());
            return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($exceptionResult->getHandler(), new ExecutionResult())));
        }
        elseif ($solutionCount !== 1) {
            //if more than 2 possible solutions, check score to decide
            $first = null;
            $second = null;
            foreach ($solutions as $solutionScore => $value) {
                if ($first === null) { $first = $solutionScore; }
                elseif ($second === null) { $second = $solutionScore; }
                else { break; }
            }
            if ($first !== $second) {
                return $solutions[0];
            }
            //when both solutions(or even more) have same score throw Exception

            $exceptionResult = $exHandler->handle(new AmbiguousOverloadFunctionCallException($solutions, $solutionScores));
            if ($exceptionResult instanceof ExceptionHandlingResultNoShove) {
                return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($exceptionResult->getHandler(), new ExecutionResult())));
            } if ($exceptionResult instanceof ExceptionHandlingResultShove) {
                $shoveValue = $exceptionResult->getShoveBackValue();
                $intValidator = new IntegerType();
                if ($intValidator->validate($shoveValue)->isSuccess() &&
                    array_key_exists($shoveValue->v(), $solutions)) {

                    return $solutions[$shoveValue->v()];
                } else {
                    return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($exceptionResult->getHandler(), new ExecutionResult())));
                }
            }
        }


        return $solutions[0];
    }
}
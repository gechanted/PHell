<?php

namespace PHell\Flow\Functions\StandardFunctions;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Data\Strin;
use PHell\Flow\Data\Datatypes\StringType;
use PHell\Flow\Data\Datatypes\UnknownDatatype;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\Parenthesis\DataFunctionParenthesis;
use PHell\Flow\Functions\Parenthesis\NamedDataFunctionParenthesis;
use PHell\Flow\Functions\Parenthesis\ValidatorFunctionParenthesis;
use PHell\Flow\Functions\Parenthesis\ValidatorFunctionParenthesisParameter;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;
use PHell\Flow\Main\Statement;

class Dump extends StandardLambdaFunction
{

    public function __construct()
    {
        parent::__construct('dump',
            new ValidatorFunctionParenthesis(
                [new ValidatorFunctionParenthesisParameter('anything', new UnknownDatatype())],
                new StringType()));
    }

    public function getReturnLoad(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler, NamedDataFunctionParenthesis $parenthesis, FunctionObject $stack): ReturnLoad
    {
        $dump = '';
        foreach ($parenthesis->getParameters() as $parameter) {
            $dump .= self::dump($parameter->getData());
        }

        return new DataReturnLoad(new Strin($dump));
    }


    /**
     * @param (int|false)[] $contenders
     * searches for the lowest number in the array
     * disregards false
     */
    private static function first(array $contenders): int|false
    {
        $first = false;
        foreach ($contenders as $contender) {
            if ($contender === false) { continue; }
            if ($first === false) { $first = $contender; }
            if ($first > $contender) { //if first is bigger than the contender
                $first = $contender;
            }
        }
        return $first;
    }

    private static function isEscaped($formattedStr): bool
    {
        //if the 2nd last is a \   AND if the last was not escaped
        return (substr($formattedStr, -2, 1) === '\\') && !self::isEscaped(substr($formattedStr, 0, strlen($formattedStr)-1));
    }

    public static function dump(DataInterface $data): string
    {
        $unformattedStr = $data->dumpValue();
        $unformattedStr = str_replace(PHP_EOL, "\n", $unformattedStr); //\r\n counts as two chars, messes stuff up
        $formattedStr = '';
        $string = false;
        $indent = 0;
        while (true) {
            $squareBracketOpen = strpos($unformattedStr, '[');
            $squareBracketClose = strpos($unformattedStr, ']');
            $bracesOpen = strpos($unformattedStr, '{');
            $bracesClose = strpos($unformattedStr, '}');
            $quotation = strpos($unformattedStr, '"');
            $endOfLine = strpos($unformattedStr, "\n");

            $contenders = [$squareBracketOpen, $squareBracketClose, $bracesOpen, $bracesClose, $quotation, $endOfLine];
            $winner = self::first($contenders);
            //if next char is searched for e.g. []{}"' $winner = 0

            $toAddFormattedStr = substr($unformattedStr, 0, $winner + 1);
            $unformattedStr = substr($unformattedStr, $winner + 1);
            if ($string) {
                //if last char is "     and  if that char is NOT escaped / has backslashes before it
                if ($winner === $quotation && (self::isEscaped($toAddFormattedStr) === false)) {
                    $string = false;
                }
                $toAddFormattedStr = self::stringUnescape($toAddFormattedStr);
                $formattedStr .= $toAddFormattedStr;
            } else {
                $formattedStr .= $toAddFormattedStr;
                if ($quotation === $winner) { $string = true; }
                elseif ($squareBracketOpen === $winner) { $indent++; }
                elseif ($squareBracketClose === $winner) { $indent--; }
                elseif ($bracesOpen === $winner) { $indent++; }
                elseif ($bracesClose === $winner) { $indent--; }
                elseif ($endOfLine === $winner) {
                    for ($i = $indent; $i !== 0; $i--) {
                        $formattedStr .= '  ';
                    }
                }
            }
            if ($winner === false) { break; }

        }
        $formattedStr = str_replace("\n", PHP_EOL, $formattedStr); // REVERTING the top: \r\n counts as two chars, messes stuff up

        return $formattedStr;
    }

    public static function stringEscape(string $toEscape): string
    {
        $toEscape = str_replace('\\', '\\\\', $toEscape);
        return str_replace('"', '\\"', $toEscape);
    }

    public static function stringUnescape(string $toEscape): string
    {
        $toEscape = str_replace('\\\\', '\\', $toEscape);
        return str_replace('\\"', '"', $toEscape);
    }


}
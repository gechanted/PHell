<?php

namespace PHell\Flow\Functions\StandardFunctions;

use PHell\Flow\Data\Data\Strin;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;
use PHell\Flow\Main\Statement;

class Dump extends EasyStatement
{

    public function __construct(private readonly Statement $statement)
    {
    }

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        $load = $this->statement->getValue($currentEnvironment, $exHandler);
        if ($load instanceof DataReturnLoad === false) { return $load; }

        $unformattedStr = $load->getData()->dumpValue();
        $unformattedStr = str_replace(PHP_EOL, "\n", $unformattedStr);
        $formattedStr = '';
        $string = false;
        $indent = 0;
        while (true) {
            $squareBracketOpen = strpos($unformattedStr, '[');
            $squareBracketClose = strpos($unformattedStr, ']');
            $bracesOpen = strpos($unformattedStr, '{');
            $bracesClose = strpos($unformattedStr, '}');
            $stringOne = strpos($unformattedStr, "'");
            $stringTwo = strpos($unformattedStr, '"');
            $endOfLine = strpos($unformattedStr, "\n");

            $contenders = [$squareBracketOpen, $squareBracketClose, $bracesOpen, $bracesClose, $stringOne, $stringTwo, $endOfLine];
            $winner = $this->first($contenders);
            //if next char is searched for e.g. []{}"' $winner = 0
            $formattedStr .= substr($unformattedStr, 0, $winner + 1);
            $unformattedStr = substr($unformattedStr, $winner + 1);
            if ($winner === false) { break; }
            if ($string === "'" && $winner === $stringOne) {
               if ($this->isEscaped($formattedStr) === false) {
                   $string = false;
               }
            }
            elseif ($string === '"' && $winner === $stringTwo) {
                if ($this->isEscaped($formattedStr) === false) {
                    $string = false;
                }
            } else {
                if ($stringOne === $winner) { $string = "'"; }
                elseif ($stringTwo === $winner) { $string = '"'; }
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

        }
        $formattedStr = str_replace("\n", PHP_EOL, $formattedStr);
        //TODO test
        return new DataReturnLoad(new Strin($formattedStr));
    }


    /**
     * @param (int|false)[] $contenders
     * searches for the lowest number in the array
     * disregards false
     */
    private function first(array $contenders): int|false
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

    private function isEscaped($formattedStr): bool
    {
        //if the 2nd last is a \   AND if the last was not escaped
        return (substr($formattedStr, -2, 1) === '\'') && !$this->isEscaped(substr($formattedStr, 0, strlen($formattedStr)-1));
    }
}
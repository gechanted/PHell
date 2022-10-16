<?php

namespace PHell\Flow\Main\CommandActions;

class ReturnAction implements CommandAction
{

    //TODO add parameter for catapult returning
    public function __construct(private $value)
    {
    }

    public function getValue()
    {
        return $this->value;
    }
}
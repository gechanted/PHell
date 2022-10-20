<?php

namespace PHell\Flow\Exceptions;

class ShouldNotHappenException extends Exception
{

    public function __construct(string $name, string $msg, array $parentNames = [])
    {
        $parentNames[] = 'ShouldNotHappenException';
        parent::__construct($name, $msg, $parentNames);
    }
}
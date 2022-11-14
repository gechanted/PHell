<?php

namespace PHell\Flow\Exceptions;

class RuntimeException extends Exception
{

    public function __construct(string $name, string $msg, array $parentNames = [])
    {
        $parentNames[] = 'RuntimeException';
        parent::__construct($name, $msg, $parentNames);
    }
}
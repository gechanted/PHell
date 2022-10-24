<?php

namespace PHell\Flow\Exceptions;

class DataTypeMismatchException extends Exception
{

    public function __construct(string $name, string $msg, array $parentNames = [])
    {
        $parentNames[] = 'DataTypeMismatchException';
        parent::__construct($name, $msg, $parentNames);
    }
}
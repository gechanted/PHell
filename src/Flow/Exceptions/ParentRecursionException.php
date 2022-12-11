<?php

namespace PHell\Flow\Exceptions;

class ParentRecursionException extends RuntimeException
{

    public function __construct()
    {
        parent::__construct('ParentRecursionException', 'You cant extend a objects in an endless cycle: You cant extend an object, that already is a parent');
    }
}
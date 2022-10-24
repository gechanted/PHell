<?php

namespace PHell\Flow\Exceptions;

class CanOnlyThrowObjectsException extends DataTypeMismatchException
{

    const EXCEPTION_NAME = 'ThrowException';

    public function __construct()
    {
        parent::__construct(self::EXCEPTION_NAME, 'Can only throw an Object, not a Scalar');
    }
}
<?php

namespace PHell\Flow\Exceptions;

class CannotChangeForeignObjectException extends RuntimeException
{

    public function __construct()
    {
        parent::__construct('CannotChangeForeignObjectException',
            'Can not add Attribute to foreign object, only overwrite an existing Attribute', []);
    }
}
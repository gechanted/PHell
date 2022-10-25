<?php

namespace PHell\Flow\Exceptions;

use Throwable;

class PHPException extends Exception
{

    public function __construct(private readonly Throwable $throwable)
    {
        parent::__construct('PHPException', 'The PHPFunction you called threw an Exception on File-Line: '.PHP_EOL
            .$this->throwable->getFile().'-'.$this->throwable->getLine().PHP_EOL.' with this content"'.PHP_EOL.$this->throwable->getMessage().'"');
    }
}
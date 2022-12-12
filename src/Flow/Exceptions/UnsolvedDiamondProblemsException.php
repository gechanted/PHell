<?php

namespace PHell\Flow\Exceptions;

class UnsolvedDiamondProblemsException extends RuntimeException
{

    //TODO maybe specify which problems
    public function __construct()
    {
        parent::__construct('UnsolvedDiamondProblemsException', 'Due to unsolved diamond problems the object would partially inoperable');
    }
}
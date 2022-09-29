<?php

namespace PHell\Flow\Datatypes;

use PHell\Code\DatatypeValidators\DatatypeValidatorInterface;

interface DatatypeInterface extends DatatypeValidatorInterface
{
    public function getNames(): array; //function/UserNamedFunction
                                        //string
                                        //bool..
}
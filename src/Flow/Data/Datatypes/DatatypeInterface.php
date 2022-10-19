<?php

namespace PHell\Flow\Data\Datatypes;

use PHell\Flow\Data\DatatypeValidators\DatatypeValidatorInterface;

interface DatatypeInterface extends DatatypeValidatorInterface
{

    /** @return string[] */
    public function getNames(): array; //function/UserNamedFunction
                                        //string
                                        //bool..
}
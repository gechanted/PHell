<?php

namespace PHell\Code\Datatypes;

interface DatatypeInterface
{
    public function validate(DatatypeInterface $datatype);

    public function getNames(): array; //function/UserNamedFunction
                                        //string
                                        //bool..
}
<?php

namespace PHell\Flow\Data\Data;

use PHell\Flow\Data\Datatypes\DatatypeInterface;
use PHell\Flow\Main\Statement;

interface DataInterface extends Statement, DatatypeInterface
{
    public function v(); //short for value, ain't got time for that shit in long

    public function phpV(); //the php value, if it should be used in PHP

    public function dumpValue(): string; //dumps the value and not the type (while actually giving type hints like "" , or [])

    public function __toString(): string;
}
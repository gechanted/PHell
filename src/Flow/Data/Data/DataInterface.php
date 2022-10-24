<?php

namespace PHell\Flow\Data\Data;

use PHell\Flow\Data\Datatypes\DatatypeInterface;
use Phell\Flow\Main\Statement;

interface DataInterface extends Statement, DatatypeInterface
{
    public function v(); //short for value, ain't got time for that shit in long
}
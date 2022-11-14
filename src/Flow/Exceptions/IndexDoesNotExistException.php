<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Data\Data\DataInterface;

class IndexDoesNotExistException extends RuntimeException
{

    public function __construct(DataInterface $index)
    {
        parent::__construct('IndexDoesNotExistException', 'Array does not contain index of value: (' . $index->getNames()[0].') "'.$index->v().'"');
    }
}
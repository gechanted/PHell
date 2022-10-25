<?php

namespace PHell\Flow\Main\Returns;

use PHell\Flow\Data\Data\DataInterface;

class DataReturnLoad implements ReturnLoad
{

    public function __construct(private readonly ?DataInterface $dataObject)
    {
    }

    public function getData(): DataInterface
    {
        return $this->dataObject;
    }
}
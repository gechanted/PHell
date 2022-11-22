<?php

namespace PHell\Flow\Main\Returns;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Data\Voi;

class DataReturnLoad implements ReturnLoad
{

    public function __construct(private readonly DataInterface $dataObject = new Voi())
    {
    }

    public function getData(): DataInterface
    {
        return $this->dataObject;
    }
}
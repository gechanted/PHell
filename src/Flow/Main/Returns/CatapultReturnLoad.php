<?php

namespace PHell\Flow\Main\Returns;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Data\Voi;
use PHell\Flow\Functions\RunningFunction;

class CatapultReturnLoad implements ReturnLoad
{
    public function __construct(private readonly RunningFunction $target, private readonly DataInterface $data = new Voi())
    {
    }

    public function getTarget(): RunningFunction
    {
        return $this->target;
    }

    public function getData(): DataInterface
    {
        return $this->data;
    }
}
<?php

namespace Phell\Flow\Main\CommandActions;

use PHell\Flow\Data\Data\DataInterface;

class ShoveAction
{

    public function __construct(private readonly DataInterface $data)
    {
    }

    public function getData(): DataInterface
    {
        return $this->data;
    }
}
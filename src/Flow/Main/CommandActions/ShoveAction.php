<?php

namespace PHell\Flow\Main\CommandActions;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Data\Voi;

class ShoveAction implements CommandAction
{

    public function __construct(private readonly DataInterface $data = new Voi())
    {
    }

    public function getData(): DataInterface
    {
        return $this->data;
    }
}
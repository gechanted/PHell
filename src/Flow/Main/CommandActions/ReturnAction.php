<?php

namespace Phell\Flow\Main\CommandActions;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Data\RunningFunctionData;
use PHell\Flow\Data\Data\Voi;

class ReturnAction implements CommandAction
{

    public function __construct(private readonly DataInterface $value = new Voi(), private readonly ?RunningFunctionData $function = null)
    {
    }

    public function getValue(): DataInterface
    {
        return $this->value;
    }

    public function getFunction(): ?RunningFunctionData
    {
        return $this->function;
    }
}
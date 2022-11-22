<?php

namespace Phell\Flow\Main\CommandActions;

use PHell\Flow\Data\Data\RunningFunctionData;
use PHell\Flow\Data\Data\Voi;
use PHell\Flow\Data\Datatypes\DatatypeInterface;

class ReturnAction implements CommandAction
{

    public function __construct(private readonly DatatypeInterface $value = new Voi(), private readonly ?RunningFunctionData $function = null)
    {
    }

    public function getValue(): DatatypeInterface
    {
        return $this->value;
    }

    public function getFunction(): ?RunningFunctionData
    {
        return $this->function;
    }
}
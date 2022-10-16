<?php

namespace PHell\Flow\Main;

use PHell\Flow\Main\CommandActions\CommandAction;

class ExecutionResult
{

   public function __construct(private readonly ?CommandAction $action = null)
   {
   }

    public function isActionRequired(): bool
    {
        return $this->action === null;
    }

    public function getAction(): ?CommandAction
    {
        return $this->action;
    }

}
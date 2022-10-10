<?php

namespace PHell\Code;

class ExecutionResult
{

   public function __construct(private $action = null)
   {
   }

    public function isActionRequired(): bool
    {
        return $this->action === null;
    }

    public function getAction()
    {
        return $this->action;
    }

}
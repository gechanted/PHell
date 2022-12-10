<?php

namespace PHell\Flow\Main\CommandActions;

use PHell\Exceptions\ShouldntHappenException;

class ContinueAction implements CommandAction
{

    public function __construct(private int $times = 1)
    {
        if ($this->times <= 0) {
            throw new ShouldntHappenException();
        }
    }

    public function thisTime(): bool
    {
        return $this->times === 1;
    }

    public function decrement(): void
    {
        $this->times--;
    }
}
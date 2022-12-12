<?php

namespace PHell\Flow\Main;

/**
 * Statement[]
 */
class Code
{
    /**
     * @param Command[] $statements
     */
    public function __construct(private array $statements = [])
    {
    }

    /** @return Command[] */
    public function getCommands(): array
    {
        return $this->statements;
    }

    public function addCommand(Command $statement): void
    {
        $this->statements[] = $statement;
    }
}
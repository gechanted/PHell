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
    public function getStatements(): array
    {
        return $this->statements;
    }

    public function addStatement(Command $statement): void
    {
        $this->statements[] = $statement;
    }
}
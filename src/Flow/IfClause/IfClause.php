<?php
namespace PHell\Flow\IfClause;

use PHell\Code\Code;

class IfClause
{
    /**
     * IfClause constructor.
     * @param IfParenthesis $ifParenthesis
     * @param Code $code
     * @param ElseIfClause[] $elseIfs
     * @param Code|null $elsecode
     */
    public function __construct(IfParenthesis $ifParenthesis, Code $code, $elseIfs = [], Code $elsecode = null)
    {
    }
}
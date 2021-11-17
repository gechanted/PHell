<?php
require_once __DIR__ . '/../src/Code/Statement.php';

class StatementTestMock extends Statement
{
    /*
     * throws an error ! if getBool is used
     */
    public function getValue()
    {
        return 4;
    }
}
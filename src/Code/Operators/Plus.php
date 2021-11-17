<?php
namespace PHell\Code\Operators;

use PHell\Code\Datatypes\FloatInterface;
use PHell\Code\Datatypes\FloatType;
use PHell\Code\Datatypes\IntegerInterface;
use PHell\Code\Datatypes\IntegerType;
use PHell\Code\Datatypes\StringInterface;
use PHell\Code\Datatypes\StringType;
use PHell\Code\Statement;
use PHell\Exceptions\DatatypeMismatchException;

class Plus implements Statement
{
    private Statement $s1;
    private Statement $s2;

    public function __construct(Statement $s1, Statement $s2)
    {
        $this->s1 = $s1;
        $this->s2 = $s2;
    }

    /**
     * @alias: new
     */
    public static function n(Statement $s1, Statement $s2): self
    {
        return new self($s1, $s2);
    }

    /**
     * @alias: execute
     * @throws DatatypeMismatchException
     */
    public function e() {
        return $this->getValue();
    }

    /**
     * @throws DatatypeMismatchException
     */
    public function getValue()
    {
        $v1 = $this->s1->getValue();
        $v2 = $this->s2->getValue();

        if ($v1 instanceof IntegerInterface && $v2 instanceof IntegerInterface) {
            return new IntegerType($v1->getInt() + $v2->getInt());

        } elseif ($v1 instanceof FloatInterface && $v2 instanceof FloatInterface) {
            return new FloatType($v1->getFloat() + $v2->getFloat());

        } elseif ($v1 instanceof StringInterface && $v2 instanceof StringInterface) {
            return new StringType($v1->getString() . $v2->getString());

        } else {
            throw new DatatypeMismatchException($this);
        }
    }
}
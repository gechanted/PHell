<?php
namespace PHell\Code\Operators;

use PHell\Code\DatatypeValidators\FloatInterface;
use PHell\Code\DatatypeValidators\IntegerInterface;
use PHell\Code\DatatypeValidators\StringInterface;
use PHell\Exceptions\DatatypeMismatchException;
use PHell\Flow\Data\Data\Floa;
use PHell\Flow\Data\Data\Intege;
use PHell\Flow\Data\Data\Strin;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\ReturnLoad;
use PHell\Flow\Main\Statement;

class Plus extends EasyStatement
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
     * @throws DatatypeMismatchException
     */
    public function getValue()
    {
        $v1 = $this->s1->getValue();
        $v2 = $this->s2->getValue();
        //TODO redo

//        if ($v1 instanceof IntegerInterface && $v2 instanceof IntegerInterface) {
            return new Intege($v1->getInt() + $v2->getInt());

//        } elseif ($v1 instanceof FloatInterface && $v2 instanceof FloatInterface) {
            return new Floa($v1->getFloat() + $v2->getFloat());

//        } elseif ($v1 instanceof StringInterface && $v2 instanceof StringInterface) {
            return new Strin($v1->getString() . $v2->getString());

//        }else {
            throw new DatatypeMismatchException($this);
//        }
    }

    public function value(FunctionObject $currentEnvironment): ReturnLoad
    {
        // TODO: Implement value() method.
    }
}
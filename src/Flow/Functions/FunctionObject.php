<?php

namespace PHell\Flow\Functions;

class FunctionObject
{
    /**
     * @var FunctionObject[]
     */
    private array $parents = [];

    /**
     * @var null|FunctionObject
     * that cool js bullshit I'm trying to copy
     * gives access to functions and variables
     * usage of strict limits this
     */
    private ?FunctionObject $originator; //superior, senior

    /**
     * @var FunctionObject|null
     * provides global FUNCTIONS which should simulate "classes"
     */
    private ?FunctionObject $stack; //runningFunction

    public function __construct(?FunctionObject $stack, ?FunctionObject $originator)
    {
        $this->stack = $stack;
        $this->originator = $originator;
    }

    private array $publicVars = [];
    private array $privateVars = [];
    private array $protectedVars = [];

    private array $publicFunctions = [];
    private array $privateFunctions = [];
    private array $protectedFunctions = [];

    /**
     * returns true if it FINDS AND SETS the value
     * otherwise returns false
     */
    private function checkAndSet(array &$array, string $index, $value): bool
    {
        if (array_key_exists($index, $array)) {
            $array[$index] = $value;
            if ($value === null) {
                unset($array[$index]);
            }
            return true;
        }
        return false;
    }

    //normal access
    public function setPublicFunction(FunctionObject $function, string $name): void { $this->publicFunctions[$name] = $function; }
    public function setProtectedFunction(FunctionObject $function, string $name): void { $this->protectedFunctions[$name] = $function; }
    public function setPrivateFunction(FunctionObject $function, string $name): void { $this->privateFunctions[$name] = $function; }


    public function setOriginatorVar(string $index, $value): bool
    {
        if ($this->checkAndSetOriginatorVar($index, $value) === false) {
            $array[$index] = $value;
            if ($value === null) { //if this true, sth weird happened
                unset($array[$index]);
                trigger_error('In File ' . __FILE__ . ' and line ' . __LINE__ . ' sth weird happened', E_USER_NOTICE);
            }
        }
        return true;
    }

    public function checkAndSetOriginatorVar(string $index, $value): bool
    {
        $isSet = $this->checkAndSet($this->publicVars, $index, $value) ||
            $this->checkAndSet($this->protectedVars, $index, $value) ||
            $this->checkAndSet($this->privateVars, $index, $value);

        if ($isSet === false) {
            if ($this->originator !== null) {
                return $this->originator->checkAndSetOriginatorVar($index, $value);
            }
        }

        return false;
    }

    public function getOriginatorVar(string $index)
    {
        //TODO if $this return this FunctionObject
        if (array_key_exists($index, $this->privateVars)) {
            return $this->privateVars[$index];
        }
        if (array_key_exists($index, $this->protectedVars)) {
            return $this->protectedVars[$index];
        }
        if (array_key_exists($index, $this->publicVars)) {
            return $this->publicVars[$index];
        }

        if ($this->originator !== null) {
            return $this->originator->getOriginatorVar($index);
        }
        return null;
    }

    public function getOriginatorOrStackFunction(string $index)
    {
        $function = $this->getOriginatorFunction($index);
        if ($function !== null) {
            return $function;
        }

        $function = $this->getStackFunction($index);
        if ($function !== null) {
            return $function;
        }

        return null;
    }

    public function getOriginatorFunction(string $index)
    {
        if (array_key_exists($index, $this->privateFunctions)) {
            return $this->privateFunctions[$index];
        }
        if (array_key_exists($index, $this->protectedFunctions)) {
            return $this->protectedFunctions[$index];
        }
        if (array_key_exists($index, $this->publicFunctions)) {
            return $this->publicFunctions[$index];
        }

        if ($this->originator !== null) {
            return $this->originator->getOriginatorFunction($index);
        }
        return null;
    }

    public function getStackFunction(string $index)
    {
        if (array_key_exists($index, $this->publicFunctions)) {
            return $this->publicFunctions[$index];
        }
        //allow private (and protected function access?)
        //first impression: no   , why allow private & protected?
        //private classes, only available for the following stack ... idk

        if ($this->stack !== null) {
            return $this->stack->getStackFunction($index);
        }
        return null;
    }

    // call to object

    //call from outside to this object
    public function getObjectOuterVar(string $index)
    {
        if (array_key_exists($index, $this->publicFunctions)) {
            return $this->publicFunctions[$index];
        }

        foreach ($this->parents as $parent) {
            $var = $parent->getObjectOuterVar($index);
            if ($var !== null) {
                return $var;
            }
        }
        return null;
    }

    public function setObjectOuterVar(string $index, $value): bool
    {
        if ($this->checkAndSet($this->publicVars, $index, $value)) {
            return true;
        }
        foreach ($this->parents as $parent) {
            if ($parent->setObjectOuterVar($index, $value)) {
                return true; //parent has variable
            }
        }

        return false;
    }

    //call to protected : only in parent available
    public function getProtectedVariable(string $index)
    {
        $var = $this->protectedVars[$index];
        if ($var !== null) {
            return $var;
        }

        $var = $this->publicVars[$index];
        if ($var !== null) {
            return $var;
        }

        foreach ($this->parents as $parent) {
            $var = $parent->getProtectedVariable($index);
            if ($var !== null) {
                return $var;
            }
        }
        return null;
    }

//    public function setProtectedVariable(string $index, $value)
//    {
//        if (array_key_exists($index, $this->protectedVars)) {
//            $this->protectedVars[$index] = $value;
//            if ($value === null) {
//                unset($this->protectedVars[$index]);
//            }
//            return true;
//        }
//        foreach ($this->parents as $parent) {
//            if ($parent->setProtectedParentVariable($index, $value)) {
//                //parent has variable
//                return true;
//            }
//        }
//        if ($this->setObjectOuterVar($index, $value)) {
//            return true;
//        }
//
//        $this->protectedVars[$index] = $value;
//        if ($value === null) {
//            unset($this->protectedVars[$index]);
//        }
//        return true;
//    }

    public function setProtectedParentVariable(string $index, $value): bool
    {
        if (array_key_exists($index, $this->protectedVars)) {
            $this->protectedVars[$index] = $value;
            if ($value === null) {
                unset($this->protectedVars[$index]);
            }
            return true;
        }
        foreach ($this->parents as $parent) {
            if ($parent->setProtectedParentVariable($index, $value)) {
                //parent has variable
                return true;
            }
        }
        return false;
    }

    //call from inside to this object
    //call to $this->etc
    public function getObjectInnerVar(string $index)
    {
        $var = $this->privateVars[$index];
        if ($var !== null) {
            return $var;
        }

        $var = $this->getProtectedVariable($index);
        if ($var !== null) {
            return $var;
        }

        return null;
    }

    public function setObjectInnerVar(string $index, $value): bool
    {
        if ($this->checkAndSet($this->privateVars, $index, $value)) {
            return true;
        }
        if ($this->setProtectedParentVariable($index, $value)) {
            return true;
        }

        //TODO maybe throw sth here?
        $this->privateVars[$index] = $value;
        if ($value === null) {
            unset($this->privateVars[$index]);
        }
        return true;
    }

//    public function setPrivateParentVariable(string $index, $value): bool
//    {
//        if (array_key_exists($index, $this->privateVars)) {
//            $this->privateVars[$index] = $value;
//            if ($value === null) {
//                unset($this->privateVars[$index]);
//            }
//            return true;
//        }
//        foreach ($this->parents as $parent) {
//            if ($parent->setPrivateParentVariable($index, $value)) {
//                //parent has variable
//                return true;
//            }
//        }
//        return false;
//    }

//    public function setPublicVar(string $index, $value): bool
//    {
//        foreach ($this->parents as $parent) {
//            if ($parent->setObjectOuterVar($index, $value)) {
//                return true; //parent has variable
//            }
//        }
//        $this->publicVars[$index] = $value;
//        if ($value === null) {
//            unset($this->publicVars[$index]);
//        }
//        return true;
//    }
}
<?php

namespace PHell\Flow\Functions;

class FunctionObject
{
    /**
     * @var FunctionObject[]
     */
    private array $parents = [];

    /**
     * @var FunctionObject|null
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


    private array $publicVars = [];
    private array $privateVars = [];
    private array $protectedVars = [];

    private array $publicFunctions = [];
    private array $privateFunctions = [];
    private array $protectedFunctions = [];
    public function getFunction(){}
    public function setFunction(){}

    public function getVariableFromOutside(string $index) { return $this->getPublicVariable($index); }
    public function getVariableFromInside(string $index) { return $this->getPrivateVariable($index); }

    public function getPublicVariable(string $index)
    {
        $var = $this->publicVars[$index];
        if ($var !== null) {
            return $var;
        }

        foreach ($this->parents as $parent) {
            $var = $parent->getPublicVariable($index);
            if ($var !== null) {
                return $var;
            }
        }
        return null;
    }

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

    public function getPrivateVariable(string $index)
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

//    public function getStackVariable(string $index)
//    {
//        if ($this->stack !== null) {
//            return $this->stack->getParentStackVariable($index);
//        }
//        return null;
//    }
//
//    public function getParentStackVariable(string $index)
//    {
//        if ($this->stack !== null) {
//            $var = $this->stack->getParentStackVariable($index);
//            if ($var !== null) {
//                return $var;
//            }
//        }
//        $var = $this->stack->getPrivateVariable($index);
//        if ($var !== null) {
//            return $var;
//        }
//
//        return null;
//    }
//
//    /**
//     * @throws VariableNotFoundException
//     */
//    public function setStackVariable(string $index)
//    {
//        if ($this->stack !== null) {
//            if ($this->stack->setParentStackVariable($index)) {
//                return;
//            }
//        }
//        throw new VariableNotFoundException($this);
//    }
//
//    public function setParentStackVariable(string $index): bool
//    {
//        if ($this->stack !== null) {
//            $var = $this->stack->setParentStackVariable($index);
//            if ($var) {
//                return true;
//            }
//        }
//        $var = $this->stack->setPrivateVariable($index);
//        if ($var !== null) {
//            return true;
//        }
//
//        return false;
//    }

    public function setPublicVariable(string $index, $value): bool
    {
        foreach ($this->parents as $parent) {
            if ($parent->setPublicParentVariable($index, $value)) {
                //parent has variable
                return true;
            }
        }
        $this->publicVars[$index] = $value;
        if ($value === null) {
            unset($this->publicVars[$index]);
        }
        return true;
    }

    /**
     * returns true if it FINDS AND SETS the value
     * otherwise returns false
     */
    public function setPublicParentVariable(string $index, $value): bool
    {
        if (array_key_exists($index, $this->publicVars)) {
            $this->publicVars[$index] = $value;
            if ($value === null) {
                unset($this->publicVars[$index]);
            }
            return true;
        }
        foreach ($this->parents as $parent) {
            if ($parent->setPublicParentVariable($index, $value)) {
                //parent has variable
                return true;
            }
        }

        return false;
    }

    public function setProtectedVariable(string $index, $value)
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
        if ($this->setPublicParentVariable($index, $value)) {
            return true;
        }

        $this->protectedVars[$index] = $value;
        if ($value === null) {
            unset($this->protectedVars[$index]);
        }
        return true;
    }

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

    public function setPrivateVariable(string $index, $value): bool
    {
        if (array_key_exists($index, $this->privateVars)) {
            $this->privateVars[$index] = $value;
            if ($value === null) {
                unset($this->privateVars[$index]);
            }
            return true;
        }
        foreach ($this->parents as $parent) {
            if ($parent->setPrivateParentVariable($index, $value)) {
                //parent has variable
                return true;
            }
        }
        if ($this->setProtectedParentVariable($index, $value)) {
            return true;
        }

        $this->privateVars[$index] = $value;
        if ($value === null) {
            unset($this->privateVars[$index]);
        }
        return true;
    }

    public function setPrivateParentVariable(string $index, $value): bool
    {
        if (array_key_exists($index, $this->privateVars)) {
            $this->privateVars[$index] = $value;
            if ($value === null) {
                unset($this->privateVars[$index]);
            }
            return true;
        }
        foreach ($this->parents as $parent) {
            if ($parent->setPrivateParentVariable($index, $value)) {
                //parent has variable
                return true;
            }
        }
        return false;
    }
}